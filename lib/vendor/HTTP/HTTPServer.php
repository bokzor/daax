<?php

defined('MSG_DONTWAIT') || define('MSG_DONTWAIT', 0);

require_once 'HTTPServerException.php';
require_once 'HTTPRequest.php';
require_once 'HTTPResponse.php';
require_once 'HTTPServerClientCollection.php';
require_once 'WebSocketFrame.php';

/**
 * HTTP Server class that handles HTTP and WebSocket traffic
 *
 * @package HTTP
 * @version 1.0.0
 * @author Alin Roman <scorpion_nr913@yahoo.com>
 * @link http://codecanyon.net/user/nr913/portfolio?ref=nr913
 */
class HTTPServer {

	const ADDRESS_ANY  = 0;
	const PORT_HTTP	   = 80;
	const ACCEPT_QUEUE = 200;
	const CHUNK_SIZE   = 1024;

	/**
	 * The server's listening socket
	 *
	 * @var resource
	 */
	protected $_serverSocket;

	/**
	 * The collection of connected HTTP clients
	 *
	 * @var HTTPServerClientCollection
	 */
	protected $_clients;

	/**
	 * Create a HTTP server and start listening
	 *
	 * @param string $address
	 * @param int $port
	 * @throws HTTPServerException
	 */
	public function __construct($address = self::ADDRESS_ANY, $port = self::PORT_HTTP) {
		$this->_serverSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($this->_serverSocket === false) {
			throw new HTTPServerException('Cannot create server socket');
		}
		if (socket_bind($this->_serverSocket, $address, $port) === false) {
			throw new HTTPServerException("Cannot bind server on {$address}:{$port}");
		}
		if (socket_set_nonblock($this->_serverSocket) === false) {
			throw new HTTPServerException('Cannot set non-blocking mode');
		}
		if (socket_set_option($this->_serverSocket, SOL_SOCKET, SO_REUSEADDR, 1) === false) {
			throw new HTTPServerException('Cannot set socket option');
		}
		if (socket_listen($this->_serverSocket, self::ACCEPT_QUEUE) === false) {
			throw new HTTPServerException('Cannot set server in listening mode');
		}
		$this->_clients = new HTTPServerClientCollection();
	}

	/**
	 * Disconnect all clients and shut down the listening socket
	 */
	public function __destruct() {
		foreach ($this->_clients as $client) {
			$this->disconnect($client);
		}
		socket_shutdown($this->_serverSocket);
		socket_close($this->_serverSocket);
	}

	/**
	 * Process a server frame from an external loop
	 *
	 * @throws HTTPServerException
	 */
	public function processFrame() {
		$read = $this->_clients->getSocketsToRead();
		$read []= $this->_serverSocket;
		$except = $write = null;
		if (socket_select($read, $write, $except, 0) === false) {
			throw new HTTPServerException('An error occured while checking for changes in sockets');
		}
		if (in_array($this->_serverSocket, $read)) {
			$socket = socket_accept($this->_serverSocket);
			if ($socket === false) {
				throw new HTTPServerException('Cannot accept client');
			}
			$client = new HTTPServerClient($socket);
			$this->_clients->addClient($client);
			$this->clientConnected($client);
			$key = array_search($this->_serverSocket, $read);
			$read[$key] = $socket;
		}
		foreach ($read as $socket) {
			$client = $this->_clients[$socket];
			$data = '';
			$dataLength = @socket_recv($socket, $data, self::CHUNK_SIZE, 0);
			if ($dataLength === false) {
				//throw new HTTPServerException('An error occured while receiving data from client');
			} else if ($dataLength == 0) {
				$this->disconnect($client);
			} else {
				$buffer = $client->getReadBuffer();
				$buffer .= $data;
				$requestClass = $client->getRequest();
				$requestMethod = '_request' . $requestClass;
				$request = new $requestClass;
				try {
					$offset = $request->parse($buffer);
					$buffer = substr($buffer, $offset);
					$this->$requestMethod($client, $request);
				} catch (HTTPParseException $e) {
					continue;
				} catch (WebSocketParseException $e) {
					continue;
				}
			}
		}
		return $this;
	}

	/**
	 * The client wants a connection upgrade to WebSockets
	 *
	 * @param HTTPServerClient $client
	 * @param array $protocols
	 * @return boolean
	 */
	protected function acceptUpgrade($client, &$protocols) {
		return true;
	}

	/**
	 * The client is connected
	 *
	 * @param HTTPServerClient $client
	 */
	protected function clientConnected(HTTPServerClient $client) {

	}

	/**
	 * The client is disconnected
	 *
	 * @param HTTPServerClient $client
	 */
	protected function clientDisconnected(HTTPServerClient $client) {

	}

	/**
	 * Disconnect the client
	 *
	 * @param HTTPServerClient $client
	 */
	public function disconnect(HTTPServerClient $client) {
		$this->clientDisconnected($client);
		@socket_shutdown($client->getSocket());
		@socket_close($client->getSocket());
		$this->_clients->removeClient($client);
		return $this;
	}

	/**
	 * WebSocket frame handling
	 *
	 * @param HTTPServerClient $client
	 * @param WebSocketFrame $frame
	 */
	private function _requestWebSocketFrame(HTTPServerClient $client, WebSocketFrame $frame) {
		if ($frame->getOpCode() == WebSocketFrame::FRAME_CLOSE) {
			$this->disconnect($client);
		} else if ($frame->getOpCode() == WebSocketFrame::FRAME_PING) {
			$frame = new WebSocketFrame();
			$frame->setOpCode(WebSocketFrame::FRAME_PONG);
			$this->send($client, $frame);
		} else {
			$this->frame($client, $frame);
		}
	}

	/**
	 * HTTP request handling
	 *
	 * @param HTTPServerClient $client
	 * @param HTTPRequest $request
	 */
	private function _requestHTTPRequest(HTTPServerClient $client, HTTPRequest $request) {
		if ($request->getHttpVerb() == 'GET'
				&& version_compare('1.1', $request->getHttpVersion()) <= 0
				&& $request->getHttpHeader('Host') !== null
				&& $request->getHttpHeader('Upgrade') !== null
				&& strpos(strtolower($request->getHttpHeader('Upgrade')), 'websocket') >= 0
				&& $request->getHttpHeader('Connection') !== null
				&& strpos(strtolower($request->getHttpHeader('Connection')), 'upgrade') >= 0
				&& $request->getHttpHeader('Sec-WebSocket-Key') !== null) {
			$protocols = $request->getHttpHeader('Sec-WebSocket-Protocol');
			if ($protocols === null) {
				$protocols = array();
			}
			$response = new HTTPResponse();
			if ($this->acceptUpgrade($client, $protocols)) {
				$key = $request->getHttpHeader('Sec-WebSocket-Key');
				$key .= '258EAFA5-E914-47DA-95CA-C5AB0DC85B11';
				$key = base64_encode(pack('H*', sha1($key)));
				$response->setHttpStatus(101, 'Switching Protocols');
				$response->setHttpHeaders(array(
					'Upgrade' => 'websocket',
					'Connection' => 'Upgrade',
					'Sec-WebSocket-Accept' => $key,
				));
				if (count($protocols)) {
					$response->setHttpHeader('Sec-WebSocket-Protocol', implode(', ', $protocols));
				}
				$client->setRequest('WebSocketFrame');
			} else {
				$response->setHttpStatus(404, 'Connection upgrade rejected');
				$response->setHttpHeaders(array(
					'Connection' => 'Close',
					'X-WebSocket-Reject-Reason' => 'Connection rejected',
				));
			}
			$this->send($client, $response);
		} else {
			$this->request($client, $request);
		}
	}

	/**
	 * The client sent a WebSocket frame
	 *
	 * @param HTTPServerClient $client
	 * @param WebSocketFrame $frame
	 */
	protected function frame(HTTPServerClient $client, WebSocketFrame $frame) {
		$this->send($client, $frame);
	}

	/**
	 * The client send a HTTP request
	 *
	 * @param HTTPServerClient $client
	 * @param HTTPRequest $request
	 */
	protected function request(HTTPServerClient $client, HTTPRequest $request) {
		$response = new HTTPResponse();
		$response->setHttpHeader('Connection', 'Close');
		$this->send($client, $response);
		$this->disconnect($client);
	}

	/**
	 * Send to client a response
	 *
	 * @param HTTPServerClient $client
	 * @param HTTPResponse|WebSocketFrame $response
	 * @throws HTTPServerException
	 */
	public function send(HTTPServerClient $client, $response) {
		$response = (string) $response;
		socket_send($client->getSocket(), $response, strlen($response), MSG_DONTWAIT);
		return $this;
	}

}
