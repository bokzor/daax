<?php

require_once 'HTTPServerClientCollectionException.php';
require_once 'HTTPServerClient.php';

/**
 * HTTP server's collection of clients
 *
 * @package HTTP
 * @subpackage Server
 * @version 1.0.0
 * @author Alin Roman <scorpion_nr913@yahoo.com>
 * @link http://codecanyon.net/user/nr913/portfolio?ref=nr913
 */
class HTTPServerClientCollection implements Iterator, ArrayAccess {

	/**
	 * The array of server clients
	 *
	 * @var array
	 */
	protected $_clients = array();

	/**
	 * Client index used to iterator
	 *
	 * @var int
	 */
	protected $_clientIndex = 0;

	/**
	 * Gets an array of client sockets for read
	 *
	 * @return array
	 */
	public function getSocketsToRead() {
		$sockets = array();
		foreach ($this->_clients as $client) {
			$sockets []= $client->getSocket();
		}
		return $sockets;
	}

	public function key() {
		return $this->_clientIndex;
	}

	public function next() {
		$this->_clientIndex++;
	}

	public function rewind() {
		$this->_clientIndex = 0;
	}

	public function valid() {
		return $this->_clientIndex < count($this->_clients);
	}

	public function current() {
		return $this->_clients[$this->_clientIndex];
	}

	public function offsetExists($offset) {
		return isset($this->_clients[$offset]);
	}

	public function offsetGet($offset) {
		if (is_resource($offset)) {
			foreach ($this->_clients as $client) {
				if ($client->getSocket() == $offset) {
					return $client;
				}
			}
			throw new HTTPServerClientCollectionException('Undefined client for specified socket');
		} else {
			return $this->_clients[$offset];
		}
	}

	public function offsetSet($offset, $value) {
		throw new HTTPServerClientCollectionException('Not allowed to set client object');
	}

	public function offsetUnset($offset) {
		throw new HTTPServerClientCollectionException('Not allowed to unset client object');
		;
	}

	/**
	 * Adds a server client to collection
	 *
	 * @param HTTPServerClient $client
	 */
	public function addClient(HTTPServerClient $client) {
		$this->_clients [] = $client;
	}

	/**
	 * Removes a server client from collection
	 *
	 * @param HTTPServerClient $client
	 */
	public function removeClient(HTTPServerClient $client) {
		for ($i = 0; $i < count($this->_clients); ++$i) {
			if ($this->_clients[$i] == $client) {
				for ($j = $i + 1; $j < count($this->_clients); ++$j) {
					$this->_clients[$j - 1] = $this->_clients[$j];
				}
				array_pop($this->_clients);
				if ($i < $this->_clientIndex) {
					$this->_clientIndex--;
				}
				break;
			}
		}
	}

}
