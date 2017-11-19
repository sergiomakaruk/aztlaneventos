<?php


class ConnectionMySql implements IConnection {

	private $db;
	/**
	 * @return IRecordset
	 */
	function getRecordset() {
		return new RecordsetMySql($this->db);
	}
	/**
	 * @param string $strCon
	 * @return void
	 */
	function open($cp) {
die($cp);
		$this->db=mysql_connect($cp->server.":".$cp->port, $cp->uid, $cp->pwd)
		or die("Error al conectar con la base de datos: host/usuario/contrase&#241;a");

		mysql_select_db($cp->database,$this->db)
		or die("No existe la base de datos: ".$cp->database	);
	}
	/**
	 * @param string $sql
	 * @return array
	 */
	function execute($sql){
		$result = mysql_query($sql, $this->db);
		if (!$result){
			throw new Exception(mysql_error(), mysql_errno());
			return;
		}
		return $result;
	}
	/**
	 * @return void
	 */
	function close(){
		if($this->db)
			mysql_close ($this->db);
	}

	public function isClosed(){
		return ($this->db);
	}
}

?>
