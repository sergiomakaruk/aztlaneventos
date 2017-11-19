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
class RecordsetMySql implements IRecordset {
	private $db;
	private $result;
	private $rs;
	public $eof=true;

	/**
	 * @param IConnection $db
	 * @return void
	 */
	public function __construct($db){
		$this->db=$db;
	}
	/**
	 * @param string $sql
	 * @return void
	 */
	public function execute($sql) {
		$this->result = mysql_query($sql, $this->db);
		if (!$this->result) {
			throw new Exception(mysql_error(),mysql_errno());
		} else {
			if ($this->rs = mysql_fetch_object($this->result)) {
				$this->eof = false;
			} else {
				$this->eof = true;
			}
		}
	}
	/**
	 *
	 * @param string $sql
	 * @return string
	 */
	public function getJSON($sql){
		$ret=array();
		$this->result = mysql_query($sql, $this->db);
		if (!$this->result) {
			throw new Exception(mysql_error(),mysql_errno());
		}
		while ($row = mysql_fetch_object($this->result)) {
			$ret[]=$row;
		}
		return @json_encode($ret);
	}
	/**
	 *
	 * @param string $sql
	 * @return array <stdClass>
	 */
	public function getObjects($sql){
		$ret=array();
		$this->result = mysql_query($sql, $this->db);
		if (!$this->result) {
			throw new Exception(mysql_error(),mysql_errno());
		}
		while ($row = mysql_fetch_object($this->result)) {
			$o=null;
			foreach ($row as $k=>$v){
				$o->$k=utf8Encode($v);
			}
			$ret[]=$o;
		}
		return $ret;
	}
	/**
	 *
	 * @param string $sql
	 * @return stdClass
	 */
	public function getObject($sql){
		$ret=null;
		$this->result = mysql_query($sql, $this->db);
		if (!$this->result) {
			throw new Exception(mysql_error(),mysql_errno());
		}
		$r=mysql_fetch_object($this->result);
		if(!$r) return null;

		foreach ($r as $k=>$v){
			$ret->$k=utf8Encode($v);
		}
		return $ret;
	}
	/**
	 * @return void
	 */
	public function moveNext() {
		if ($this->rs = mysql_fetch_object($this->result)) {
			$this->eof = false;
		} else {
			$this->eof = true;
		}

	}
	/**
	 * @param string $value
	 * @return string
	 */
	public function field($value) {
		return utf8Encode($this->rs->$value);
	}
	/**
	 * @param string $value
	 * @return int
	 */
	public function getInt($value){
		return intval($this->field($value));
	}
	/**
	 * @param string $value
	 * @return double
	 */
	public function getDouble($value){
		return doubleval($this->field($value));
	}
	/**
	 * @return array
	 */
	public function rows() {
		return mysql_num_rows($this->result);
	}
	/**
	 * @return void
	 */
	public function close() {
		mysql_free_result($this->result);
	}
	/**
	 * @param string $value
	 * @return Fecha
	 */
	public function getDate($value){
		$var=$this->field($value);
		$d=new Fecha(substr($var,8,2),substr($var,5,2),substr($var,0,4),substr($var,11,2),substr($var,14,2),substr($var,17,2));
		return $d;
	}

}
?>
