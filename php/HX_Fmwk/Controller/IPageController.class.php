<?php

// 24/10/2008 00:23:56
// hugo@hexium.com.ar

interface IPageController{

	public function __construct();
	public function onLoad();
	public function onUnLoad();
	public function init();
	public function onPreRender();
	public function onRender();
	public function dispose();

}
?>