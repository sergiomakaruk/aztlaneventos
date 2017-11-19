<?php

// 23/10/2008 22:30:16
// hugo@hexium.com.ar

class Server {

	private function __construct(){

	}
	static function APP_ROOT_PATH(){
		return rootPath;
	}
	static function HTTP_ACCEPT_LANGUAGE(){
		return $_SERVER["HTTP_ACCEPT_LANGUAGE"];
	}
	static function SERVER_SOFTWARE(){
		return $_SERVER["SERVER_SOFTWARE"];
	}
	static function SERVER_NAME(){
		return $_SERVER["SERVER_NAME"];
	}
	static function SERVER_ADDR(){
		return $_SERVER["SERVER_ADDR"];
	}
	static function SERVER_PORT(){
		return $_SERVER["SERVER_PORT"];
	}
	static function REMOTE_ADDR(){
		return $_SERVER["REMOTE_ADDR"];
	}
	static function DOCUMENT_ROOT(){
		return $_SERVER["DOCUMENT_ROOT"];
	}
	static function SCRIPT_FILENAME(){
		return $_SERVER["SCRIPT_FILENAME"];
	}
	static function SCRIPT_NAME(){
		return $_SERVER["SCRIPT_NAME"];
	}
	static function PHP_SELF(){
		return $_SERVER["PHP_SELF"];
	}

}
?>