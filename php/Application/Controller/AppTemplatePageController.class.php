<?php

class AppTemplatePageController extends TemplatePageController {
	var $mensaje="";

	public function __construct(){

		HX_Fmwk::registerApplication(Application::appKey("application"));

		parent::__construct();

		$this->setTemplateDir(Server::APP_ROOT_PATH().Application::appConfig("templateDir"));
		$this->setCompileDir(Server::APP_ROOT_PATH().Application::appConfig("templateCompileDir"));
		$this->setCompileId(str_replace("/", ".",Server::PHP_SELF()));
		//set_exception_handler(array($this, 'errorHandler'));

	}

	public function errorHandler($excepcion) {
		header("location: ../error/");
	}



	public function onPreRender(){

		parent::onPreRender();
		
		#remove the directory path we don't want
		$request  = str_replace("/aztlanback/", "", $_SERVER['REQUEST_URI']);
		//$request = $_SERVER['REQUEST_URI'];
		
		echo $request;
		#split the path by '/'
		$params     = explode("/", $request);
		var_dump($params);
		 
		$safe_pages = array("home", "search", "thread");
		
		if(in_array($params[0], $safe_pages)) {
			include($params[0].".php");
		} else {
			include("404.php");
		}
	}
}

?>