<?php

class SET_camp extends DA_Abs{

	public static function setEstadistica($camp){
		$owner = $camp->owners_idOwner;
		$fuente = $camp->source->idFuente;
		
		$camp = $camp->idCamp;
		
		$ip = self::getRealIP();
		$ips = array('181.46.62.91','200.114.218.114');
		if (in_array($ip, $ips)) return 1;
		
		$url = null;
		
		$fecha = new Fecha();
		$toView = $fecha->format('Y-m-d');

		$sql = "INSERT INTO estadisticas (ip,url,navegador,camp,owner,fuente,fecha,fecha_simple)
				VALUES (
				'$ip','$url','$navegador',$camp,$owner,$fuente,'$fecha','$toView')";

		try
		{
			$db = Conexion::getConexion('usuarios');
			//echo $sql;die;
			$db->execute($sql);			
		}
		catch (Exception $e) {
			$c = $e->getCode();			
			throw new AppException("setEstadistica(): Error inesperado ($c):" . $e->getMessage(), 200);			
		}
				
		return 1;		
	}
	
	public static function getRealIP() 
	{
		 if (!empty($_SERVER['HTTP_CLIENT_IP']))
		  return $_SERVER['HTTP_CLIENT_IP'];
		  
		 if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
		  return $_SERVER['HTTP_X_FORWARDED_FOR'];
		 
		 return $_SERVER['REMOTE_ADDR'];
	}
	
	public static function setUsuario($evt,$owner,$source,$params){
		
		$nombre = escape($params->nombre);
		$apellido = escape($params->apellido);
		$dni = (property_exists($params, 'dni')) ? escape($params->dni) : '';
		$email = escape($params->email);
		$tel = escape($params->telefono);
		$facebook = escape($params->facebook);
		
		$tipo = escape($evt->tipo->nombre);
		$source = escape($source->nombre);
		$owner = escape($owner->nombre);
		//$idCamp = escape($camp->idCamp);		
	
		$fecha = new Fecha();

		$sql = "INSERT INTO usuarios (nombre,apellido,dni,email,telefono,facebook,tipo,source,owner,campaing,creado)
				VALUES (
				'$nombre','$apellido','$dni','$email','$tel','$facebook','$tipo','$source','$owner','','$fecha')";
		try
		{
			$db = Conexion::getConexion('usuarios');
			//echo $sql;die;
			$db->execute($sql);
			//$nid = self::lastId($db);
			//return $nid;
		}
		catch (Exception $e) {
			$c = $e->getCode();			
			if($c != 1062)throw new AppException("setUsuario(): Error inesperado ($c):" . $e->getMessage(), 200);
			else{
				$sql = "UPDATE usuarios SET
				nombre='$nombre',
				apellido='$apellido',
				dni='$dni',
				telefono='$tel',
				facebook='$facebook'
				WHERE email='$email'";
				//echo $sql;die;
				try{
					$db->execute($sql);
				}catch (Exception $e) {
					throw new AppException("setUsuarioUPDATE(): Error inesperado ($c):" . $e->getMessage(), 200);
				}			
			}
		}
		
		return GET_camp::getUsuario($email);
	}
	
	public static function setReserva($evt,$owner,$source,$params,$idUsuario){
		$evento = $evt->idEvento;
		$lugares = 1;
		$sou = $source->idFuente;
		$own = $owner->idOwner;
		//$camp = $camp->idCamp;
		
		$sql = "INSERT INTO reservas (eventos_idEvento,usuarios_idUsuario,cantLugares,fecha,camp_idCamp,source,owners_idOwner,confirmado,tipoUsuario)
				VALUES (
				$evento,$idUsuario,$lugares,now(),0,$sou,$own,0,1)";
		//echo $sql;die;
		try
		{
			$db = Conexion::getConexion('usuarios');			
			$db->execute($sql);
			return true;
		}
		catch (Exception $e) {
			$c = $e->getCode();			
			throw new AppException("setReserva(): Error inesperado ($c):" . $e->getMessage(), 200);			
		}
	}
	
	public static function setConsulta($params,$idUsuario){		
		$consulta = $params->consulta;		
		
		$sql = "INSERT INTO consultas (usuarios_idUsuario,consulta)
				VALUES (
				$idUsuario,'$consulta')";
		try
		{
			$db = Conexion::getConexion('usuarios');
			//echo $sql;die;
			$db->execute($sql);

			return true;
		}
		catch (Exception $e) {
			$c = $e->getCode();			
			throw new AppException("setConsulta(): Error inesperado ($c):" . $e->getMessage(), 200);			
		}
	}
}

?>