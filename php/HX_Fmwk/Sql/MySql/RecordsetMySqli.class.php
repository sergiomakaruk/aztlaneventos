<?php
/**
 * Date: 22/08/2012 16:37:29
 * @version 1.0
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2012, Hugo Vazquez
 * @package
 **/

/**
 *
 **/

class RecordsetMySqli implements IRecordset{
	/**
	 *
	 * @var mysqli
	 */
	private $db;
	/**
	 *
	 * @var mysqli_result
	 */
	private $result;
	/**
	 *
	 * @var stdClass
	 */
	private $rs;

	/**
	 *
	 * @var boolean
	 */
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
	 * @throws MySqliException
	 */
	public function execute($sql) {
		$this->result=$this->db->query($sql);
		if(!$this->result){
			throw new MySqliException(new Exception($this->db->error,$this->db->errno));
		}
		$this->rs=$this->result->fetch_object();
		$this->eof=(is_null($this->rs))?true:false;
	}
	/**
	 *
	 * @param string $sql
	 * @return string
	 */
	public function getJSON($sql){
		$ret=array();
		$this->result=$this->db->query($sql);
		if(!$this->result){
			throw new MySqliException(new Exception($this->db->error,$this->db->errno));
		}
		while ($row = $this->result->fetch_object()) {
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
		$this->result=$this->db->query($sql);
		if(!$this->result){
			throw new MySqliException(new Exception($this->db->error,$this->db->errno));
		}
		while ($row = $this->result->fetch_object()) {
			$o=new stdClass();
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
	 * @return null|stdClass
	 */
	public function getObject($sql){
		$ret=null;
		$this->result=$this->db->query($sql);
		if(!$this->result){
			throw new MySqliException(new Exception($this->db->error,$this->db->errno));
		}
		$r=$this->result->fetch_object();
		if(is_null($r)) return $ret;

		$ret=new stdClass();

		foreach ($r as $k=>$v){
			$ret->$k=utf8Encode($v);
		}
		return $ret;
	}
	/**
	 * @return void
	 */
	public function moveNext() {
		if ($this->rs = $this->result->fetch_object()) {
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
	 * @param string $value
	 * @return Fecha
	 */
	public function getDate($value){
		return new Fecha($this->field($value));
	}
	/**
	 * @return int
	 */
	public function rows() {
		return $this->result->num_rows;
	}
	/**
	 * @return void
	 */
	public function close() {
		$this->result->free();
	}
}
?>