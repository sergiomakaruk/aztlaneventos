<?php

// 23/10/2008 22:22:25

abstract class PageController implements IPageController {

	/* order de inicio de la clase (Controller)
	 $classTmp->init();
	$classTmp->onLoad();
	$classTmp->onPreRender();
	$classTmp->onRender();
	$classTmp->onUnLoad();
	$classTmp->dispose();
	*
	* */

	public function __construct(){
	}

	public function clear(){
		$this->attributes=array();
	}

	public function init(){
		//IOTrafficController::init();
		//var_dump("init");
	}

	public function onLoad(){
		//var_dump("onLoad");
	}

	public function onUnLoad(){
		//var_dump("onUnLoad");
	}

	public function onPreRender(){
		//var_dump("preRender");
	}
	public function onRender(){
		//var_dump("render");
	}

	public function close(){
		//IOTrafficController::appLog($this->pageType);
	}

	public final function dispose(){
		//var_dump("dispose");
		Conexion::closeAll();

	}
}
?>