<?php

class GET_contactos extends DA_Abs{
	
	public static function formastro(){
	
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();
	
		$sql="SELECT * from formulario_contacto_astro";
		//$sql="SELECT * from usuarios";
		return $rs->getObjects($sql);
	}
	
	public static function formPsico(){
	
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();
	
		$sql="SELECT * from formulario_contacto";
		//$sql="SELECT * from usuarios";
		return $rs->getObjects($sql);
	}

	public static function getUsuarios(){

		$db=Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();
		
		$sql="SELECT * from usuarios LIMIT 20";	
		$sql="SELECT * from usuarios";
		return $rs->getObjects($sql);
	}
	
	public static function getAlumnoEmail($mail){
	
		$db=Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();
	
		$sql="SELECT * from alumnos WHERE mail LIKE '$mail'";		
		return $rs->getObject($sql);
	}
	
}

?>