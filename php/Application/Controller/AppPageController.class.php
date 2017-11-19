<?php

class AppPageController extends PageController {

	public function __construct(){

		HX_Fmwk::registerApplication(Application::appKey("application"));
		parent::__construct();

	}
	
}
?>