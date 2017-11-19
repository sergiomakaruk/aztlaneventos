<?php
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
class MySqlException extends Exception {
	/**
	 * @param Exception $e
	 * @return void
	 */
	public function __construct($e){

		switch ($e->getCode()) {
			case 1062:
				parent::__construct("DB_ERR_DUP_ENTRY", $e->getCode());
				break;
			case 1136:
				parent::__construct("DB_ERR_WRONG_VALUE_COUNT_ON_ROW", $e->getCode());
				break;
			case 1146:
				parent::__construct("DB_ERR_NO_SUCH_TABLE", $e->getCode());
				break;
			default:
				parent::__construct($e->getMessage(), 0);
				break;
		}

		//Logger::logError($e);
	}
}
?>