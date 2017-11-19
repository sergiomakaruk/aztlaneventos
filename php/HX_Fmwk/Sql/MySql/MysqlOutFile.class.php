<?php
/**
 * Date: 23/08/2012 16:05:38
 * @version 1.0
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2012, Hugo Vazquez
 * @package
 **/

/**
 *
 **/

class MysqlOutFile{

	private function __construct(){
	}
	/**
	 * Retorna el full path del archivo generado en formato csv
	 * @param array $head
	 * @param string $sqlData
	 * @throws BackofficeException
	 * @return string
	 */
	public static function generarCSV($head,$sqlData){
		$file=addslashes(tempnam(sys_get_temp_dir(), "_csv_"));
		@unlink($file);
		$db = Conexion :: getConexion();

		$sqlHead="select cast('".implode("' as char(255)),cast('",$head)."' as char(255))";
		try {

			$db->execute("drop temporary table if exists temp");
			$db->execute("CREATE TEMPORARY TABLE temp ".$sqlHead);
			$db->execute("insert into temp ".$sqlData);

			$db->execute("select * from temp
					INTO OUTFILE '$file'
					FIELDS TERMINATED BY ';'
					ESCAPED BY '\"'
					OPTIONALLY ENCLOSED BY '\"'
					LINES TERMINATED BY '\r\n'");

			$db->execute("drop temporary table if exists temp");

			return $file;
		} catch (Exception $e) {
			throw new BackofficeException($e->getMessage());
		}
	}
	/**
	 * Retorna el full path del archivo generado en formato XLS
	 * @param array $head
	 * @param string $sqlData
	 * @throws BackofficeException
	 * @return string
	 */
	public static function generarXLS($head,$sqlData){
		$file=addslashes(tempnam(sys_get_temp_dir(), "_csv_"));
		@unlink($file);
		$db = Conexion :: getConexion();

		$sqlHead="select cast('".implode("' as char(255)),cast('",$head)."' as char(255))";
		try {

			$db->execute("drop temporary table if exists temp");
			$db->execute("CREATE TEMPORARY TABLE temp ".$sqlHead);
			$db->execute("insert into temp ".$sqlData);

			$db->execute("select * from temp
					INTO OUTFILE '$file'
					FIELDS TERMINATED BY '\t'
					LINES TERMINATED BY '\n'");

			$db->execute("drop temporary table if exists temp");

			return $file;
		} catch (Exception $e) {
			throw new BackofficeException($e->getMessage());
		}
	}

}

?>