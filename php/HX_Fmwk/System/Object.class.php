<?php
class Object {

	protected $attributes = array();

	public function __construct(){}

	public function __get($key){

		return array_key_exists($key, $this->attributes) ? $this->attributes[$key] : null;
	}

	public function __set($key, $value){
		$this->attributes[$key] = $value;
	}

	public function getClass(){
		return get_class($this);
	}
}
?>