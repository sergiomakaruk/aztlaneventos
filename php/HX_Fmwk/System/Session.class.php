<?php


class Session {

	private function Session() {
	}

	public static function set($key,$value){
		$_SESSION[$key]=serialize($value);
	}
	public static function get($key) {
		if (isset ($_SESSION[$key])) {
			return unserialize($_SESSION[$key]);
		} else {
			return null;
		}
	}


	public static function unRegister($key) {
		$_SESSION[$key]=null;
		unset($_SESSION[$key]);

	}

	public static function id(){
		return session_id();
	}

	public static function un_Set(){
		session_unset();
	}
	public static function destroy(){
		session_destroy();
	}


}
?>