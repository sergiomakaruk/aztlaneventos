<?php
/**
 * Date: 26/10/2011 14:19:55
 * @version 1.0
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2011, Hugo Vazquez
 *
 */

set_exception_handler("SerializableController::sendError");

abstract class PageSerializableController extends PageController implements IserializableController{


	var $data=null;
	public function __construct(){
		$this->pageType=PageType::service;
		parent::__construct();
		$this->data=SerializableController::getData();
	}

	function addToSend($obj, $name=null){
		SerializableController::addToSend($obj, $name);
	}

	function send($msg=""){
		SerializableController::send();
	}

}
?>