<?php
/**
 * Date: 25/11/2008 09:41:54
 * @version 1.0
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2012, Hugo Vazquez
 * @package HX_Fmwk/Sql
 * @filesource
 **/

/**
 *
 **/
class Conexion{

	private static $conexiones=array();

	private function __construct(){

	}
	/**
	 * @param string|null $value
	 * @return IConnection
	 */
	public static  function getConexion($value=null){

		$value=(is_null($value))?"default":$value;

		if(array_key_exists($value, self::$conexiones)){
			if(!self::$conexiones[$value]->isClosed())
				return self::$conexiones[$value];
		}

		$cadena=Configuration::connectionString($value);
		$pos=strpos($cadena,";");

		$drv=substr($cadena,0,$pos);
		$cp=new ConnProperty(substr($cadena,$pos+1));

		switch (strtolower($drv)){
			case "drv=mysql":
				self::$conexiones[$value]=new ConnectionMySql();
				self::$conexiones[$value]->open($cp);
				break;
			case "drv=mysqli":
				self::$conexiones[$value]=new ConnectionMySqli();
				self::$conexiones[$value]->open($cp);
				break;
		}
		return self::$conexiones[$value];

	}
	/**
	 * @param string|null $value
	 * @return void
	 *
	 */
	public static  function close($value=""){

		$value=($value=="")?"default":$value;

		if(array_key_exists($value, self::$conexiones)){
			self::$conexiones[$value]->close();
			unset(self::$conexiones[$value]);
		}
	}
	/**
	 * @return void
	 */
	public static function closeAll(){
		foreach(array_keys(self::$conexiones) as $value){
			self::close($value);
		}
	}

}

/**
 * Date: 25/11/2008 09:41:54
 * @version 1.0
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2012, Hugo Vazquez
 * @package HX_Fmwk/Sql/MySql
 * @filesource
 **/

/**
 *
 **/
class ConnProperty{

	var $server="";
	var $database="";
	var $uid="";
	var $pwd="";
	var $port="";

	/**
	 * @param string $strConn
	 * @return void
	 */
	public function __construct($strConn){

		$vConn=explode(";",$strConn);

		foreach ($vConn as $valor){

			$v=explode("=",$valor);

			switch (strtolower($v[0])){
				case "server":
					$this->server=$v[1];
					break;
				case "database":
					$this->database=$v[1];
					break;
				case "uid":
					$this->uid=$v[1];
					break;
				case "pwd":
					$this->pwd=$v[1];
					break;
				case "port":
					$this->port=$v[1];
					break;
			}
		}
	}

}
?>