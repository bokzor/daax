<?php
set_time_limit(0);
class BackgroundScript {
	const SCRIPT_TIMEOUT = 2;
	
	protected static $sidHandle = null;

	public static function runFile($file, $runningContent = '') {
		self::setContinousRunning($runningContent);
		
		ob_start();
		include($file);
		ob_end_clean();
	}
	
	public static function runFileOnce($file, $runningContent = '', $alreadyRunningContent = '') {
		if (self::isRunning($file)) {
			echo $alreadyRunningContent;
			exit;
		}
		declare(ticks=10);
		register_tick_function(array(__CLASS__, 'keepAlive'), $file);
		self::runFile($file, $runningContent);
	}
	
	public static function runOnce($file, $runningContent = '', $alreadyRunningContent = '') {
		if (self::isRunning($file)) {
			echo $alreadyRunningContent;
			exit;
		}
		declare(ticks=10);
		register_tick_function(array(__CLASS__, 'keepAlive'), $file);
		
		self::setContinousRunning($runningContent);
		ob_start();
		register_shutdown_function(array(__CLASS__, 'scriptFinished'));
	}
	
	public static function scriptFinished() {
		ob_end_clean();
		if (self::$sidHandle != null) {
			fclose(self::$sidHandle);
		}
	}
	
	public static function isRunning($file) {
		$sidFile = self::getSidFile($file);
		if (!file_exists($sidFile)) {
			return false;
		}
		$sidHandle = fopen(self::getSidFile($file), 'r');
		$scriptTime = intval(fgets($sidHandle));
		if (time() - $scriptTime > self::SCRIPT_TIMEOUT) {
			return false;
		}
		fclose($sidHandle);
		return true;
	}
	
	public static function keepAlive($file) {
		static $sidHandle = null;
		static $lastTime = 0;
		if (self::$sidHandle == null) {
			self::$sidHandle = fopen(self::getSidFile($file), 'w');
		}
		$nowTime = time();
		if ($lastTime != $nowTime) {
			ftruncate(self::$sidHandle, 0);
			fseek(self::$sidHandle, 0, SEEK_SET);
			fwrite(self::$sidHandle, $nowTime);
			$lastTime = $nowTime;
		}
	}
	
	protected static function setContinousRunning($content = '') {
		ignore_user_abort(1);
		set_time_limit(0);
		ob_start();
		echo $content;
		session_write_close();
		header('Content-Length: ' . ob_get_length());
		header('Connection: Close');
		echo ob_get_clean();
		ob_flush();
		flush();
	}
	
	protected static function getSidFile($file) {
		return self::getTempDir() . DIRECTORY_SEPARATOR . md5($file) . '.sid';
	}
	
	protected static function getTempDir() {
		if (function_exists('sys_get_temp_dir')) {
			return realpath(sys_get_temp_dir());
		}
		if (!empty($_ENV['TMP'])) {
			return realpath($_ENV['TMP']);
		}
		if (!empty($_ENV['TMPDIR'])) {
			return realpath( $_ENV['TMPDIR']);
		}
		if (!empty($_ENV['TEMP'])) {
			return realpath( $_ENV['TEMP']);
		}
		$tempfile = tempnam(__FILE__, '');
		if (file_exists($tempfile)) {
			unlink($tempfile);
			return realpath(dirname($tempfile));
		}
		return null;
	}
}


class MyWebServer extends HTTPServer {

	protected $_run = false;

	public function Start() {
		$this->_run = true;

		while ($this->_run) {
			$this->processFrame();
			usleep(1);
		}
	}

	public function Stop() {
		$this->_run = false;
	}

	protected function request(HTTPServerClient $client, HTTPRequest $request) {
		echo 'Someone (' . $client->getIpAddress() . ') requested a file (' . $request->getHttpPath() . ')' . "\n";

		$path = $request->getHttpPath();
		$response = new HTTPResponse();

		if ($path == '/exit') {
			$this->Stop();
			$response->setHttpStatus(200, 'OK');
			return $this->send($client, $response)->disconnect($client);
		}

		if ($path == '/') {
			$path = '/index.html';
		}

		if (!file_exists('./resources' . $path)) {
			$response->setHttpStatus(404, 'Not Found');
			return $this->send($client, $response)->disconnect($client);
		}

		$response->setHttpStatus(200, 'OK');
		$response->setHttpHeader('Content-Type', 'text/html');

		$response->setHttpBody(file_get_contents('./resources' . $path));

		return $this->send($client, $response)->disconnect($client);
	}

	protected function acceptUpgrade($client, &$protocols) {
		echo 'Someone (' . $client->getIpAddress() . ') requested a WebSocket connection upgrade' . "\n";

		return true;
	}

	protected function frame(HTTPServerClient $client, WebSocketFrame $frame) {
		echo 'Someone (' . $client->getIpAddress() . ') sent a WebSocket frame message (' . $frame->getPayLoad() . ')' . "\n";

		$response = new WebSocketFrame();
		$response->setPayLoad('Message received! Coucou');

		return $this->send($client, $response);
	}

}
