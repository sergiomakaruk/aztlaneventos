<?php
/**
 * Date: 22/08/2012 16:36:59
 * @version 1.0
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2012, Hugo Vazquez
 * @package
 **/

/**
 *
 **/

class ConnectionMySqli implements IConnection {

	private $db;
	/**
	 * @return IRecordset
	 */
	function getRecordset() {
		return new RecordsetMySqli($this->db);
	}
	/**
	 * @param string $strCon
	 *  @throws MySqliException
	 */
	function open($cp) {

		$this->db=new mysqli($cp->server, $cp->uid, $cp->pwd, $cp->database, $cp->port);
		if ($this->db->connect_errno) {
			throw new MySqliException(new Exception($this->db->connect_error,$this->db->connect_errno));
		}
	}
	/**
	 * @param string $sql
	 * @throws MySqliException
	 * @return int
	 */
	function execute($sql){
		if(!$this->db->query($sql)){
			throw new MySqliException(new Exception($this->db->error,$this->db->errno));
		}
		return $this->db->affected_rows;
	}
	/**
	 * @return void
	 */
	function close(){
		if(is_null($this->db)) return;

		mysqli_close($this->db);
		$this->db=null;
	}
	public function isClosed(){
		return is_null($this->db);
	}
}

?>