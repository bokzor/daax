<?php

require_once 'HTTPRequestException.php';
require_once 'HTTPParseException.php';

/**
 * HTTP Request sent by client to server
 *
 * @package HTTP
 * @version 1.0.0
 * @author Alin Roman <scorpion_nr913@yahoo.com>
 * @link http://codecanyon.net/user/nr913/portfolio?ref=nr913
 */
class HTTPRequest {

	/**
	 * The HTTP version
	 *
	 * @var string
	 */
	protected $_httpVersion = '1.1';

	/**
	 * The HTTP action verb
	 *
	 * @var string
	 */
	protected $_httpVerb = 'GET';

	/**
	 * The HTTP script path
	 *
	 * @var string
	 */
	protected $_httpPath = '/';

	/**
	 * An associative array of HTTP headers
	 *
	 * @var array
	 */
	protected $_httpHeaders = array();

	/**
	 * The HTTP request body data
	 *
	 * @var string
	 */
	protected $_httpBody = '';

	/**
	 * Sets the HTTP version to use
	 *
	 * @param string $version
	 * @throws HTTPRequestException
	 */
	public function setHttpVersion($version) {
		if (!in_array($version, array('1.0', '1.1'))) {
			throw new HTTPRequestException('Unsuported HTTP version');
		}
		$this->_httpVersion = $version;
	}

	/**
	 * Gets the HTTP version
	 *
	 * @return string
	 */
	public function getHttpVersion() {
		return $this->_httpVersion;
	}

	/**
	 * Sets the HTTP action verb to use
	 *
	 * @param string $verb
	 * @throws HTTPRequestException
	 */
	public function setHttpVerb($verb) {
		$verbs = array(
			'1.0' => array('GET', 'POST', 'HEAD'),
			'1.1' => array('GET', 'POST', 'HEAD', 'OPTIONS', 'PUT', 'DELETE', 'TRACE', 'CONNECT')
		);
		if (!in_array($verb, $verbs[$this->_httpVersion])) {
			throw new HTTPRequestException('Invalid HTTP verb');
		}
		$this->_httpVerb = $verb;
	}

	/**
	 * Gets the HTTP action verb
	 *
	 * @return string
	 */
	public function getHttpVerb() {
		return $this->_httpVerb;
	}

	/**
	 * Sets the HTTP script path
	 *
	 * @param string $path
	 */
	public function setHttpPath($path) {
		$this->_httpPath = $path;
	}

	/**
	 * Gets the HTTP script path
	 *
	 * @return string
	 */
	public function getHttpPath() {
		return $this->_httpPath;
	}

	/**
	 * Set a HTTP header
	 *
	 * @param string $header
	 * @param string $value
	 */
	public function setHttpHeader($header, $value) {
		$this->_httpHeaders[$header] = $value;
	}

	/**
	 * Gets a HTTP header
	 *
	 * @param string $header
	 * @return null|string
	 */
	public function getHttpHeader($header) {
		if (array_key_exists($header, $this->_httpHeaders)) {
			return $this->_httpHeaders[$header];
		}
		return null;
	}

	/**
	 * Removes a HTTP header
	 *
	 * @param string $header
	 * @return boolean
	 */
	public function removeHttpHeader($header) {
		if (array_key_exists($header, $this->_httpHeaders)) {
			unset($this->_httpHeaders[$header]);
			return true;
		}
		return false;
	}

	/**
	 * Set all HTTP headers
	 *
	 * @param array $headers
	 * @throws HTTPRequestException
	 */
	public function setHttpHeaders($headers) {
		if (!is_array($headers)) {
			throw new HTTPRequestException('Invalid HTTP headers');
		}
		$this->_httpHeaders = $headers;
		$this->setHttpBody($this->getHttpBody());
	}

	/**
	 * Gets all HTTP headers
	 *
	 * @return array
	 */
	public function getHttpHeaders() {
		return $this->_httpHeaders;
	}

	/**
	 * Sets HTTP body data
	 *
	 * @param string $body
	 */
	public function setHttpBody($body) {
		$this->_httpBody = $body;
		$bodyLength = strlen($body);
		if ($bodyLength == 0) {
			$this->removeHttpHeader('Content-Length');
		} else {
			$this->setHttpHeader('Content-Length', $bodyLength);
		}
	}

	/**
	 * Gets HTTP body data
	 *
	 * @return string
	 */
	public function getHttpBody() {
		return $this->_httpBody;
	}

	/**
	 * Converts the request to network packet
	 *
	 * @return string
	 */
	public function __toString() {
		$request = "HTTP/{$this->_httpVersion} {$this->_httpStatusCode} {$this->_httpStatusMessage}\r\n";
		foreach ($this->_httpHeaders as $header => $value) {
			$request .= "{$header}: $value\r\n";
		}
		$request .= "\r\n{$this->_httpBody}";
		return $request;
	}

	/**
	 * Converts the network packet to HTTP request
	 *
	 * @param string $data
	 * @return int
	 * @throws HTTPParseException
	 */
	public function parse($data) {
		$dataLength = strlen($data);
		$matches = array();
		if (!preg_match('/^.*?\r?\n\r?\n/s', $data, $matches)) {
			throw new HTTPParseException('Header section not ended');
		}
		list($header) = $matches;
		$headerLength = strlen($header);

		if (!preg_match('/^([a-z]+) ([^\r\n]+) HTTP\/(1\.0|1\.1)(.*)\r?\n\r?\n$/is', $header, $matches)) {
			throw new HTTPParseException('Invalid status line');
		}
		list(
				$header,
				$httpVerb,
				$httpPath,
				$httpVersion,
				$headersBlock
				) = $matches;
		$this->setHttpVersion($httpVersion);
		$this->setHttpVerb(strtoupper($httpVerb));
		$this->setHttpPath($httpPath);
		preg_match_all('/\r?\n\s*([^:]+):\s*([^\r\n]+)/', $headersBlock, $matches, PREG_SET_ORDER);
		foreach ($matches as $match) {
			list($headerLine, $header, $value) = $match;
			$this->setHttpHeader(trim($header), trim($value));
		}
		$bodyLength = $this->getHttpHeader('Content-Length');
		if ($bodyLength === null) {
			$bodyLength = 0;
		}
		if ($headerLength + $bodyLength > $dataLength) {
			throw new HTTPParseException('Incomplete data supplied');
		}
		$this->setHttpBody(substr($data, $headerLength, $bodyLength));
		return $headerLength + $bodyLength;
	}

}
