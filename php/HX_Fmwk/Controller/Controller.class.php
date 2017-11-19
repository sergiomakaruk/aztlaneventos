<?php

// 23/10/2008 20:01:48

abstract class Controller{

	private function __construct(){
	}

	public static function load($className){

		if(@class_exists($className)){

			$classTmp=new $className;

			$classTmp->init();
			$classTmp->onLoad();
			$classTmp->onPreRender();
			$classTmp->onRender();
			$classTmp->onUnLoad();
			$classTmp->close();
			$classTmp->dispose();
			return;
		}

		throw new Exception("Controller::load() / Controlador no encontrado: ".$className);

	}
}
?>