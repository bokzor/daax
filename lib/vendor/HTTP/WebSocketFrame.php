<?php

require_once 'WebSocketFrameException.php';
require_once 'WebSocketParseException.php';

/**
 * WebSocket frame used for request and response
 *
 * @package HTTP
 * @subpackage WebSocket
 * @version 1.0.0
 * @author Alin Roman <scorpion_nr913@yahoo.com>
 * @link http://codecanyon.net/user/nr913/portfolio?ref=nr913
 */
class WebSocketFrame {

	const FRAME_CONTINUE = 0;
	const FRAME_TEXT = 1;
	const FRAME_BINARY = 2;
	const FRAME_CLOSE = 8;
	const FRAME_PING = 9;
	const FRAME_PONG = 10;

	/**
	 * Final frame flag
	 *
	 * @var boolean
	 */
	protected $_endFrame = true;

	/**
	 * The frame's opcode
	 *
	 * @var int
	 */
	protected $_opCode = self::FRAME_TEXT;

	/**
	 * Frame payload data
	 *
	 * @var string
	 */
	protected $_payLoad = '';

	/**
	 * Sets the final frame flag
	 *
	 * @param boolean $end
	 */
	public function setEndFrame($end = true) {
		$this->_endFrame = $end;
	}

	/**
	 * Gets the final frame flag
	 *
	 * @return boolean
	 */
	public function getEndFrame() {
		return $this->_endFrame;
	}

	/**
	 * Sets the frame's opcode
	 *
	 * @param int $opCode
	 * @throws WebSocketFrameException
	 */
	public function setOpCode($opCode) {
		if ($opCode > 15 || $opCode < 0) {
			throw new WebSocketFrameException('Invalid frame opcode');
		}
		if ($opCode == self::FRAME_CONTINUE && $this->getEndFrame()) {
			throw new WebSocketFrameException('Cannot set continue opcode on ending frame');
		}
		$this->_opCode = $opCode;
	}

	/**
	 * Gets the frame's opcode
	 *
	 * @return int
	 */
	public function getOpCode() {
		return $this->_opCode;
	}

	/**
	 * Sets the frame payload data
	 *
	 * @param string $data
	 */
	public function setPayLoad($data) {
		$this->_payLoad = $data;
	}

	/**
	 * Gets the frame payload data
	 *
	 * @return string
	 */
	public function getPayLoad() {
		return $this->_payLoad;
	}

	/**
	 * Converts a WebSocket frame to a network packet
	 *
	 * @return string
	 */
	public function __toString() {
		$frame = '';
		$frame .= pack('C', ($this->_endFrame ? 128 : 0) | $this->_opCode & 15);
		$payLoadLength = strlen($this->_payLoad);
		if ($payLoadLength < 126) {
			$frame .= pack('C', $payLoadLength);
		} else if ($payLoadLength < 256 * 256) {
			$frame .= pack('Cn', 126, $payLoadLength);
		} else {
			$frame .= pack('CNN', 127, $payLoadLength >> 32, $payLoadLength);
		}
		$frame .= $this->_payLoad;
		return $frame;
	}

	/**
	 * Converts a network packet to a WebSocket frame
	 *
	 * @param string $data
	 * @return int
	 * @throws WebSocketParseException
	 */
	public function parse($data) {
		$dataLength = strlen($data);
		$byte = unpack('CA/CB', substr($data, 0, 2));
		$this->setEndFrame(($byte['A'] & 128) > 0);
		$this->setOpCode($byte['A'] & 15);
		$masked = ($byte['B'] & (1 << 7)) > 0;
		$payLoadLength = $byte['B'] & 127;
		$offset = 2;
		if ($payLoadLength == 126) {
			$offset += 2;
			$payLoadLength = unpack('nA', substr($data, 1, 2));
			$payLoadLength = $payLoadLength['A'];
		} else if ($payLoadLength == 127) {
			$offset += 8;
			$payLoadLength = unpack('NA/NB', substr($data, 1, 8));
			$payLoadLength = ($payLoadLength['A'] << 32) + $payLoadLength['B'];
		}
		$mask = '';
		if ($masked) {
			$mask = substr($data, $offset, 4);
			$offset += 4;
		}
		if ($offset + $payLoadLength > $dataLength) {
			throw new WebSocketParseException('Incomplete data supplied');
		}
		$data = substr($data, $offset, $payLoadLength);
		if ($masked) {
			for ($i = 0; $i < $payLoadLength; ++$i) {
				$data[$i] = chr(ord($data[$i]) ^ ord($mask[$i % 4]));
			}
		}
		$this->setPayLoad($data);
		return $offset + $payLoadLength;
	}

}
