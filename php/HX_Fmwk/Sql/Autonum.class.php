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
class Autonum {

	private function __construct(){
	}

	/**
	 * @return int
	 */

	public static function getNewId() {
		$id = 0;

		$db = Conexion :: getConexion();

		$sql = "insert into autonum () values ()";

		$db->execute($sql);

		$rs = $db->getRecordset();
		$rs->execute("select last_insert_id() as id");
		$id = intval($rs->field("id"));

		$rs->close();

		return $id;
	}

}

/*
 DROP TABLE IF EXISTS autonum;

CREATE TABLE  autonum (
		`id` int(10) NOT NULL auto_increment,
		`fecha` timestamp NOT NULL default CURRENT_TIMESTAMP,
		PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=latin1;

*/

?>