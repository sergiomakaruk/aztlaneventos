<?php


set_exception_handler("SerializableController::sendError");

abstract class PageSerializableController extends PageController implements IserializableController{


	var $data=null;
	public function __construct(){
		parent::__construct();
		$this->data=SerializableController::getData();
	}

	function addToSend($obj, $name=null){
		SerializableController::addToSend($obj, $name);
	}

	function send($msg=""){
		SerializableController::send($msg);
	}

}
?>