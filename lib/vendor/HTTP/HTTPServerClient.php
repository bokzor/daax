<?php

require_once 'HTTPServerClientException.php';

/**
 * HTTP server's client
 *
 * @package HTTP
 * @subpackage Server
 * @version 1.0.0
 * @author Alin Roman <scorpion_nr913@yahoo.com>
 * @link http://codecanyon.net/user/nr913/portfolio?ref=nr913
 */
class HTTPServerClient {

	/**
	 * The client's socket
	 *
	 * @var resource
	 */
	protected $_socket;

	/**
	 * The client's read buffer
	 *
	 * @var string
	 */
	protected $_readBuffer = '';

	/**
	 * Class used to parse the request
	 *
	 * @var string
	 */
	protected $_request = '';

	/**
	 * An associative array of user data
	 *
	 * @var array
	 */
	protected $_userData = array();

	/**
	 * Create a server client
	 *
	 * @param resource $socket
	 */
	public function __construct($socket) {
		$this->_socket = $socket;
		$this->_request = 'HTTPRequest';
	}

	/**
	 * Gets the client's socket
	 *
	 * @return resource
	 */
	public function &getSocket() {
		return $this->_socket;
	}

	/**
	 * Gets the client's buffer
	 *
	 * @return string
	 */
	public function &getReadBuffer() {
		return $this->_readBuffer;
	}

	/**
	 * Sets the class to parse the request
	 *
	 * @param string $request
	 * @throws HTTPServerClientException
	 */
	public function setRequest($request) {
		if (!class_exists($request)) {
			throw new HTTPServerClientException('Invalid request object');
		}
		$this->_request = $request;
	}

	/**
	 * Gets the class to parse the request
	 *
	 * @return string
	 */
	public function getRequest() {
		return $this->_request;
	}

	/**
	 * Sets user data
	 *
	 * @param string $key
	 * @param mixed $value
	 */
	public function setUserData($key, $value) {
		$this->_userData[$key] = $value;
	}

	/**
	 * Gets user data
	 *
	 * @param string $key
	 * @return null|mixed
	 */
	public function getUserData($key) {
		if (array_key_exists($key, $this->_userData)) {
			return $this->_userData[$key];
		}
		return null;
	}

	/**
	 * Clears user data
	 *
	 * @param string $key
	 */
	public function clearUserData($key) {
		if (array_key_exists($key, $this->_userData)) {
			unset($this->_userData[$key]);
		}
	}

	/**
	 * Gets client's IP address
	 *
	 * @return string
	 * @throws HTTPServerClientException
	 */
	public function getIpAddress() {
		$address = '';
		if (socket_getpeername($this->_socket, $address) === false) {
			throw new HTTPServerClientException('Cannot get client IP address');
		}
		return $address;
	}

}
