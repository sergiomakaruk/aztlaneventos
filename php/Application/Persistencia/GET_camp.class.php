<?php

class GET_camp extends DA_Abs{
	
	public static function getOwner($id){	
		$db=Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();	
		$sql="SELECT * FROM owners WHERE idOwner = $id";
		//echo $sql;die;
		$camp = $rs->getObject($sql);			
		return $camp;	
	}
	
	public static function getSource($id){
		$db=Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();
		$sql="SELECT * FROM fuentes WHERE idFuente = $id";
		//echo $sql;die;
		$camp = $rs->getObject($sql);
		return $camp;
	}
	
	public static function getConsultas($data){
	
		$db=Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();
	
		$sql="SELECT * FROM consultas,usuarios WHERE usuarios.idUsuario=consultas.usuarios_idUsuario ORDER BY consultas.idConsulta DESC LIMIT 30";
		//echo $sql;die;
		$camp = $rs->getObjects($sql);
			
		return $camp;
	
	}

	public static function getCamp($data){

		$id = $data->cid;
		$so = $data->so;
		$db=Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();

		$sql="SELECT * FROM campaings WHERE idCamp = $id";
		//echo $sql;die;
		$camp = $rs->getObject($sql);
		if(is_null($camp))return null;
		$camp->source = $rs->getObject("SELECT * FROM fuentes WHERE idFuente=$so");

		$o = $camp->owners_idOwner;
		$camp->owner =  $rs->getObject("SELECT * FROM owners WHERE idOwner=$o");
	
		$t = $camp->evento_idEvento;
		$camp->evento =  $rs->getObject("SELECT * FROM eventos WHERE idEvento=$t");
		
		$t = $camp->evento->tipoEvento_idTipo;
		$camp->evento->tipo =  $rs->getObject("SELECT * FROM tipos_evento WHERE idTipo=$t");

		return $camp;

	}
	
public static function getUsuario($email){
		try
		{
			$db = Conexion::getConexion('usuarios');
			$sql = "SELECT * FROM usuarios WHERE email='$email'";
			$rs=$db->getRecordset();
			return $rs->getObject($sql);			
		}
		catch (Exception $e) {
			new AppException("getUsuario(): Error inesperado ($c):" . $e->getMessage(), 200);			
		}
	}
	
public static function getFakeUsuario($id){
		try
		{
			$db = Conexion::getConexion('usuarios');
			$sql = "SELECT * FROM usuarios WHERE idUsuario='$id'";
			$rs=$db->getRecordset();
			return $rs->getObject($sql);			
		}
		catch (Exception $e) {
			new AppException("getFakeUsuario(): Error inesperado ($c):" . $e->getMessage(), 200);			
		}
	}
	
	public static function getReserva($idevt,$idUsuario){
		$evento = $idevt;
			
		$sql = "SELECT * FROM reservas WHERE usuarios_idUsuario=$idUsuario AND eventos_idEvento=$evento ORDER BY idReserva DESC  LIMIT 1";
		try
		{
		$db = Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();
		//echo $sql;die;
		return $rs->getObject($sql);
		
		}
		catch (Exception $e) {
		$c = $e->getCode();
		throw new AppException("getReserva(): Error inesperado ($c):" . $e->getMessage(), 200);
		}
	}



}

?>