<?php
class FWException extends Exception{

	/**
	 *
	 * @param FWExceptionCode $code
	 * @param string $msg
	 */
	public function __construct($code, $msg=""){
		parent::__construct("FWException: ".$msg, $code);
		Logger::logError($this);
	}
}
?>