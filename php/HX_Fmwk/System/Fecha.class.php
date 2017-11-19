<?php
/**
 * Date: 25/11/2008 09:41:54
 * @version 1.1
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2012, Hugo Vazquez
 * @package HX_Fmwk/System
 * @filesource
 **/

/**
 * version 1.1 se agrego la funcionalidad show soporte de intl
 **/

class Fecha extends DateTime {

	const DEFAULT_FORMAT="Y-m-d H:i:s";

	/**
	 * Retorna un nuevo objeto Fecha
	 * Para utilizar Unix timestamp, anteponer @ en el string de $time.
	 * @param string $time[optional]
	 * @param DateTimeZone $timezone[optional]
	 */
	function __construct($time = null, DateTimeZone $timezone = null) {
		if(is_null($timezone))
			parent::__construct($time);
		else
			parent::__construct($time,$timezone);


	}
	/**
	 * Retorna la fecha formateada en AAAA-MM-DD HH:MM:SS
	 * @return string
	 */
	public function __toString(){
		return $this->format();
	}

	/**
	 * Retorna la fecha formateada de acuerdo al string pasado
	 * @param string $format
	 * @return string
	 */
	public function format($format=self::DEFAULT_FORMAT){
		return parent::format($format);
	}
	/**
	 * Retorna la fecha formateada dependiendo del locale del cliente
	 * si el modulo intl esta activo, por defecto $dateFormatter=IntlDateFormatter::SHORT,
	 * $timeFormatter=IntlDateFormatter::MEDIUM
	 * @param IntlDateFormatter $dateFormatter
	 * @param IntlDateFormatter $timeFormatter
	 * @return string
	 */
	public function show($dateFormatter=3,$timeFormatter=2){
		if(extension_loaded("intl")){
			$locale=locale_accept_from_http($_SERVER['HTTP_ACCEPT_LANGUAGE']);
			$fmt = new IntlDateFormatter( $locale ,$dateFormatter,$timeFormatter,Application::getTimeZone());
			return $fmt->format($this);
		}else{
			return $this->format();
		}
	}


	/**
	 * Agrega la cantidad de dias segun el parametro
	 * @param int $d
	 */
	public function addDays($d){
		$this->add(new DateInterval("P".$d."D"));
	}
	/**
	 * Agrega la cantidad de horas segun el parametro
	 * @param int $d
	 */
	public function addHours($h){
		$this->add(new DateInterval("PT".$h."H"));
	}
	/**
	 * Agrega la cantidad de minutos segun el parametro
	 * @param int $d
	 */
	public function addMinutes($m){
		$this->add(new DateInterval("PT".$m."M"));
	}
	/**
	 * Compara el valor de esta instancia con un valor de Fecha especificado y
	 * devuelve un entero que indica si esta instancia es anterior, igual o posterior
	 * al valor de Fecha especificado
	 * @param Fecha $fecha
	 * @return number
	 */
	public function compareTo(Fecha $value){
		if($this->getTimestamp()>$value->getTimestamp()){
			return 1;
		}elseif($this->getTimestamp()==$value->getTimestamp()){
			return 0;
		}
		return -1;
	}
}
?>