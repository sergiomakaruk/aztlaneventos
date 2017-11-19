<?php

class SET_consulta extends DA_Abs{
	
	public static function getConsultas(){
	
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();
	
		$sql="SELECT * FROM formulario_contacto ORDER BY id DESC LIMIT 30";
		//echo $sql;die;
		$camp = $rs->getObjects($sql);
			
		return $camp;
	
	}
	
	public static function getConsultasAstro(){
	
		$db=Conexion::getConexion("centroastrologicoaztlan");
		$rs=$db->getRecordset();
	
		$sql="SELECT * FROM formulario_contacto ORDER BY id DESC LIMIT 30";
		//echo $sql;die;
		$camp = $rs->getObjects($sql);
			
		return $camp;
	
	}


	public static function setConsulta($data){

		$nombre = escape($data->nombre);
		$tel = escape($data->telefono);
		$email = escape($data->email);
		$consulta = escape($data->consulta);
		$dni = escape($data->dni);
		$facebook = escape($data->facebook);
		$newsletter = $data->newsletter;
		$fecha = new Fecha();

		$sqlAbs = "INSERT INTO formulario_contacto (nombre,dni,telefono,email,facebook,consulta,newsletter,fecha)
				VALUES (
				'$nombre','$dni','$tel','$email','$facebook','$consulta',$newsletter,'$fecha')";
		try
		{
			$db = Conexion::getConexion();
			//echo $sqlAbs;die;
			$db->execute($sqlAbs);

			$nid = self::lastId($db);

			return $nid;
		}
		catch (Exception $e) {
			$c = $e->getCode();
			throw new AppException("Error inesperado ($c):" . $e->getMessage(), 200);
		}
	}

}

?>