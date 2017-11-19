<?php
class HX_Fmwk {

	private static $instance=null;
	private static $application=null;
	private static $production=null;

	public static function value($name){
		return HX_Fmwk::$instance->value($name);
	}
	public static function load($config){
		HX_Fmwk::$instance=new BasicConfiguration($config);
	}

	public static function registerApplication($app){
		HX_Fmwk::$application=$app;
	}

	public static function getApplication(){
		return HX_Fmwk::$application;
	}

	public static function production(){

		if(!is_null(HX_Fmwk::$production)){
			return HX_Fmwk::$production;
		}

		if(!is_null(HX_Fmwk::value("development"))){
			if(HX_Fmwk::value("development")=="true"){
				HX_Fmwk::$production=false;
				return HX_Fmwk::$production;
			}
		}
		HX_Fmwk::$production=true;
		return HX_Fmwk::$production;
	}

}
?>