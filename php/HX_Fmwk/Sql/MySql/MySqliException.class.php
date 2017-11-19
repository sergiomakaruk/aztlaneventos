<?php
/**
 * Date: 22/08/2012 16:37:16
 * @version 1.0
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2012, Hugo Vazquez
 * @package
 **/

/**
 *
 **/

class MySqliException extends Exception {
	/**
	 * @param Exception $e
	 * @return void
	 */
	const DB_ERR_DUP_ENTRY=1062;
	const DB_ERR_WRONG_VALUE_COUNT_ON_ROW=1136;
	const DB_ERR_NO_SUCH_TABLE=1146;

	public function __construct($e){


		switch ($e->getCode()) {
			case self::DB_ERR_DUP_ENTRY:
				parent::__construct("DB_ERR_DUP_ENTRY", $e->getCode());
				break;
			case DB_ERR_WRONG_VALUE_COUNT_ON_ROW:
				parent::__construct("DB_ERR_WRONG_VALUE_COUNT_ON_ROW", $e->getCode());
				break;
			case DB_ERR_NO_SUCH_TABLE:
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