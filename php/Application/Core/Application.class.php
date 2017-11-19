<?php
class Application extends Configuration{

	private static $usuario=null;
	public static function getPathImagenesColores(){
		return Server::APP_ROOT_PATH().Application::appConfig("pathImagenesColores");
	}
	public static function getUrlImagenesColores(){
		return Application::appKey("url").Application::appConfig("urlImagenesColores");
	}
	public static function getPathImagenesProductos(){
		return Server::APP_ROOT_PATH(). Application::appConfig("pathImagenesProducto");
	}
	public static function getTmpDir(){
		return Server::APP_ROOT_PATH(). Application::appConfig("tmpDir");
	}
	public static function getUrlImagenesProductos(){
		return Application::appKey("url").Application::appConfig("urlImagenesProducto");
	}
	private static $pais=null;
	public static function getPais(){
		if(is_null(Application::$pais)){
			Application::$pais=RepoPais::obtenerPorId(Application::appKey("idPais"));
		}
		Return Application::$pais;
	}

	public static function getDefaultTimeZone(){
		return "America/Buenos_Aires";
	}
	public static function getTimeZone(){
		if(HX_Fmwk::getApplication()=="backoffice")
			return Backoffice::getUserTimeZone();

		return self::getDefaultTimeZone();
	}

	public static function getTimeZones(){
		$ret=array();
		foreach (DateTimeZone::listAbbreviations() as $k=>$v){
			if($v[0]["timezone_id"]!="")
				$ret[$v[0]["timezone_id"]]=$v[0]["timezone_id"];
		}
		return $ret;
	}
}
?>