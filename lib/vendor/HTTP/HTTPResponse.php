<?php

require_once 'HTTPResponseException.php';
require_once 'HTTPParseException.php';

/**
 * HTTP Response sent by server to client
 *
 * @package HTTP
 * @version 1.0.0
 * @author Alin Roman <scorpion_nr913@yahoo.com>
 * @link http://codecanyon.net/user/nr913/portfolio?ref=nr913
 */
class HTTPResponse {

	/**
	 * The HTTP version
	 *
	 * @var string
	 */
	protected $_httpVersion = '1.1';

	/**
	 * The HTTP status code
	 *
	 * @var int
	 */
	protected $_httpStatusCode = 200;

	/**
	 * The HTTP status message
	 *
	 * @var string
	 */
	protected $_httpStatusMessage = 'OK';

	/**
	 * An associative array of HTTP headers
	 *
	 * @var array
	 */
	protected $_httpHeaders = array();

	/**
	 * The HTTP body data
	 *
	 * @var string
	 */
	protected $_httpBody = '';

	/**
	 * Sets the HTTP version to use
	 *
	 * @param string $version
	 * @throws HTTPResponseException
	 */
	public function setHttpVersion($version) {
		if (!in_array($version, array('1.0', '1.1'))) {
			throw new HTTPResponseException('Unsuported HTTP version');
		}
		$this->_httpVersion = $version;
	}

	/**
	 * Gets the HTTP version used
	 *
	 * @return string
	 */
	public function getHttpVersion() {
		return $this->_httpVersion;
	}

	/**
	 * Sets the HTTP status code
	 *
	 * @param int $code
	 * @throws HTTPResponseException
	 */
	public function setHttpStatusCode($code) {
		if (!is_numeric($code)) {
			throw new HTTPResponseException('Invalid HTTP status code');
		}
		$this->_httpStatusCode = $code;
	}

	/**
	 * Gets the HTTP status code
	 *
	 * @return int
	 */
	public function getHttpStatusCode() {
		return $this->_httpStatusCode;
	}

	/**
	 * Sets the HTTP status message
	 *
	 * @param string $message
	 */
	public function setHttpStatusMessage($message) {
		$this->_httpStatusMessage = $message;
	}

	/**
	 * Gets the HTTP status message
	 *
	 * @return string
	 */
	public function getHttpStatusMessage() {
		return $this->_httpStatusMessage;
	}

	/**
	 * Sets the HTTP status code and message
	 *
	 * @param int $code
	 * @param string $message
	 */
	public function setHttpStatus($code, $message) {
		$this->setHttpStatusCode($code);
		$this->setHttpStatusMessage($message);
	}

	/**
	 * Sets a HTTP header
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
	 * Sets all HTTP headers
	 *
	 * @param array $headers
	 * @throws HTTPResponseException
	 */
	public function setHttpHeaders($headers) {
		if (!is_array($headers)) {
			throw new HTTPResponseException('Invalid HTTP headers');
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
	 * Converts the response to network packet
	 *
	 * @return string
	 */
	public function __toString() {
		$response = "HTTP/{$this->_httpVersion} {$this->_httpStatusCode} {$this->_httpStatusMessage}\r\n";
		foreach ($this->_httpHeaders as $header => $value) {
			$response .= "{$header}: $value\r\n";
		}
		$response .= "\r\n{$this->_httpBody}";
		return $response;
	}

	/**
	 * Converts the network packet to HTTP response
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

		if (!preg_match('/^HTTP\/(1\.0|1\.1) (\d+) ([^\r\n]+)(.*)\r?\n\r?\n$/s', $header, $matches)) {
			throw new HTTPParseException('Invalid status line');
		}
		list(
				$header,
				$httpVersion,
				$statusCode,
				$statusMessage,
				$headersBlock
				) = $matches;
		$this->setHttpVersion($httpVersion);
		$this->setHttpStatus($statusCode, $statusMessage);
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
