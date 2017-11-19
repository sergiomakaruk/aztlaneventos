<?php
/**
 * Date: 26/07/2012 13:48:20
 * @version 1.0
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2012, Hugo Vazquez
 * @package
 **/

/**
 *
 **/

class SerializableController {

	private static $toSend=array();
	private static $data=null;

	private function __construct(){
	}

	public static function getData(){
		if(is_null(self::$data)){

				if(!is_null($_REQUEST["data"])){
					self::$data=@json_decode(utf8Encode(base64_decode($_REQUEST["data"])));
				}
				else if(!is_null($_POST["data"])){
					self::$data=@json_decode(utf8Encode(base64_decode($_POST["data"])));
				}
				else if(!is_null($_GET["data"])){
					self::$data=@json_decode(utf8Encode(base64_decode($_GET["data"])));
				}
			
				if(is_null(self::$data)) self::$data=new stdClass();
		}

		foreach ($_REQUEST as $clave => $valor){
			self::$data->$clave = $valor;
		}
		
		return self::$data;
	}

	public static function addToSend($obj,$name=null){
		if(is_null($name)){
			self::$toSend[]=$obj;
		}else{
			self::$toSend[$name]=$obj;
		}
	}
	/**
	 *
	 * @param Exception $e
	 */
	public static function sendError($e){
		$code=$e->getCode();
		$msg=$e->getMessage();

		if($code>0){
			$code=-1;
			$msg="error interno de servidor";
		}
		if(Application::appConfig("debug")=="true"){
			self::sendData(array("error"=>1,
					"debugCode"=>$e->getCode(),
					"debugMsg"=>$e->getMessage(),
					"errorCode"=>$code,
					"errorMsg"=>$msg
			));
		}else{
			//Logger::logError($e);
			self::sendData(array("error"=>1,
					"errorCode"=>$code,
					"errorMsg"=>$msg
			));
		}
	}

	public static function send(){
		self::sendData(array("error"=>0,"errorCode"=>0,"errorMsg"=>"","data"=>self::$toSend));
	}
	/**
	 *
	 * @param array $data
	 */
	private static function sendData($data){
		self::sendHeaders();
		echo self::getDataToSend($data);

	}
	/**
	 *
	 * @param array $data
	 * @return string
	 */
	private static function getDataToSend($data){
		$data["last_updated"]=date("Y-m-d H:i:s");
		if(count($data["data"])==0){
			$data["data"]=new stdClass();
		}

		if(isset($_REQUEST["xml"])){
			$d=new stdClass();
			foreach ($data as $k=>$v){
				$d->$k=$v;
			}
			$sData=Encode::toXml($d);
		}else{
			$sData=@json_encode($data);
		}

		$o=new stdClass();
		if(Application::appConfig("debug")=="true"){
			$o->responseDebug=$data;
			$o->requestDebug=self::getData();
			$o->data=base64_encode($sData);
			//$o->encdata=Encriptador::encriptar($sData);

		}else{
			if(Application::appConfig("encrypt")=="true"){
				$o->data=Encriptador::encriptar($sData);
			}else{
				$o->data=base64_encode($sData);
			}
		}

		if(isset($_REQUEST["xml"]))
			return Encode::toXml($o);

		return json_encode($o);
	}
	/**
	 * Envia encabezados al cliente
	 */
	private static function sendHeaders(){
		ob_clean();
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');

		if(isset($_REQUEST["xml"]))
			header ("content-type: text/xml");
		else
			header('Content-type: application/json', true);

	}
}

?>