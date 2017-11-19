<?php

// 23/10/2008 22:20:32
// hugo@hexium.com.ar

abstract class Configuration{

	private function __construct(){
	}

	protected static $pathClass=array();
	protected static $connectionStrings=array();
	protected static $appKeys=array();
	protected static $appConfig=array();
	protected static $systemDebug=false;
	protected static $archivo="";


	public static function load($archivo){
		self::$archivo=$archivo;
		self::parsearConfigXML();
	}

	public static function systemDebug(){
		return self::$systemDebug;
	}

	public static function pathClass(){
		return self::$pathClass;
	}

	public static function connectionString($name){
		return self::$connectionStrings[$name];
	}

	public static function appKey($name){
		return self::$appKeys[$name];
	}
	public static function appConfig($name){
		return self::$appConfig[$name];
	}
	private static function parsearConfigXML(){

		$xml=new XMLParser();

		$xml->load(self::$archivo);
		if($xml->isLoaded()){

			foreach ($xml->getNodes() as $nodo1){

				switch (strtolower($nodo1->nodeName())){
					case "appsettings":
						foreach ($nodo1->getNodes() as $nodo2){
							switch (strtolower($nodo2->nodeName())){
								case "includepathclass":
									foreach ($nodo2->getNodes() as $nodo3){
										self::$pathClass[]=$nodo3->getAttribute("name");
									}
									break;
								case "connectionstrings":
									foreach ($nodo2->getNodes() as $nodo3){
										self::$connectionStrings[$nodo3->getAttribute("name")]=$nodo3->getAttribute("value");
									}
									break;
								case "appkeys":
									foreach ($nodo2->getNodes() as $nodo3){
										self::$appKeys[$nodo3->getAttribute("name")]=$nodo3->getAttribute("value");
									}
									break;
								case "appconfig":
									foreach ($nodo2->getNodes() as $nodo3){
										self::$appConfig[$nodo3->getAttribute("name")]=$nodo3->getAttribute("value");
									}
									break;
							}
						}

						break;

					case "system":
						foreach ($nodo1->getNodes() as $nodo2){
							switch (strtolower($nodo2->nodeName())){
								case "debug":
									self::$systemDebug=(strtolower($nodo2->getAttribute("value"))=="true");
									break;
							}
						}
						break;

				}

			}
		}
	}

}
?>