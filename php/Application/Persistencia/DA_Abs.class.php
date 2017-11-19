<?php

/**
 * Date: 14/08/2013 14:28:41
 * @version 1.0
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2013, Hugo Vazquez
 * @filename DA.class.php
 * @package
 **/

/**
 */
class DA_Abs {

	public static $idIdioma = null;
	public static $onlyActives = false;

	protected static function lastId($db){
		$rs = $db->getRecordset();
		$rs->execute("select last_insert_id() as id");
		$id = intval($rs->field("id"));
		$rs->close();
		return $id;
	}
}

?>