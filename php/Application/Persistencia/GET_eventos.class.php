<?php
class GET_eventos extends DA_Abs{

	public static function getOwners(){
		$db=Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();
		$sql="SELECT * from owners WHERE activo = 1 ORDER BY nombre";
		return  $rs->getObjects($sql);
	}

	public static function getSources(){
		$db=Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();
		$sql="SELECT * from fuentes";
		return  $rs->getObjects($sql);
	}

	public static function getHomeEventosAstro(){
		$db=Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();
		$sql="SELECT eventos.*,tipos_evento.tipo FROM eventos,tipos_evento
		WHERE eventos.mostrarHome = 1
		AND eventos.mostrarAstro = 1
		AND eventos.activo = 1
		AND eventos.tipoEvento_idTipo = tipos_evento.idTipo
		AND tipos_evento.tipo = 1
		AND eventos.date >= CURDATE()
		ORDER BY eventos.date ASC
		";
		//echo $sql;die;
		$eventos =  $rs->getObjects($sql);
		foreach ($eventos as $evento){
			$id = $evento->idEvento;
			$sql="SELECT idCamp FROM campaings
		WHERE evento_idEvento = $id";

			$evento->idCamp = $rs->getObject($sql)->idCamp;
		//	$evento->idCamp = $evento->idCamp->idCamp;
		}
		return $eventos;
	}

	public static function getHomeEventosPsico(){
		$db=Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();
		$sql="SELECT eventos.*,tipos_evento.tipo FROM eventos,tipos_evento
		WHERE eventos.mostrarHome = 1
		AND eventos.mostrarPsico = 1
		AND eventos.activo = 1
		AND eventos.tipoEvento_idTipo = tipos_evento.idTipo
		AND tipos_evento.tipo = 1
		AND eventos.date >= CURDATE()
		ORDER BY eventos.date ASC
		";
		//echo $sql;die;
		$eventos =  $rs->getObjects($sql);
		foreach ($eventos as $evento){
			$id = $evento->idEvento;
			$sql="SELECT idCamp FROM campaings
		WHERE evento_idEvento = $id";

			$evento->idCamp = $rs->getObject($sql)->idCamp;
		//	$evento->idCamp = $evento->idCamp->idCamp;
		}
		return $eventos;
	}
	public static function getEventos(){
		$db=Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();
		$sql="SELECT eventos.*,tipos_evento.tipo,tipos_evento.nombre as nombretipo ,lugares.* FROM eventos,tipos_evento,lugares
		WHERE eventos.tipoEvento_idTipo = tipos_evento.idTipo
		AND eventos.activo = 1
		AND tipos_evento.tipo = 1
		AND lugares.idLugar = eventos.lugar_idLugar
		ORDER BY eventos.date DESC
		LIMIT 10
		";
		//echo $sql;die;
		$eventos =  $rs->getObjects($sql);

		foreach ($eventos as $evento){
			$id = $evento->idEvento;
			$sql = "SELECT IFNULL(SUM(cantLugares),0)  as reservas FROM reservas WHERE eventos_idEvento=$id AND confirmado !=2";
			$evento->reservas = $rs->getObject($sql)->reservas;
			$sql = "SELECT IFNULL(SUM(cantLugares),0) as reservas FROM reservas WHERE eventos_idEvento=$id AND confirmado =1";
			$evento->confirmados = $rs->getObject($sql)->reservas;
			$sql = "SELECT IFNULL(SUM(anotado),0) as anotados FROM reservas WHERE eventos_idEvento=$id AND anotado =1";
			$evento->anotados = $rs->getObject($sql)->anotados;
			$sql = "SELECT IFNULL(SUM(cantLugares),0) as asistencia FROM reservas WHERE eventos_idEvento=$id AND asistencia =1";
			$evento->asistencia = $rs->getObject($sql)->asistencia;
		}

		return $eventos;
	}
	public static function getEventosByFechaAndTipo($fecha, $tipo){
		$db=Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();
		$sql="SELECT eventos.* FROM eventos
		WHERE eventos.tipoEvento_idTipo = $tipo
		AND eventos.activo = 1
		AND eventos.date = '$fecha'
		LIMIT 10
		";
		//echo $sql;die;
		$eventos =  $rs->getObjects($sql);

		foreach ($eventos as $evento){
			$id = $evento->idEvento;
			$sql = "SELECT IFNULL(SUM(cantLugares),0)  as reservas FROM reservas WHERE eventos_idEvento=$id AND confirmado !=2";
			$evento->reservas = $rs->getObject($sql)->reservas;
			$sql = "SELECT IFNULL(SUM(cantLugares),0) as reservas FROM reservas WHERE eventos_idEvento=$id AND confirmado =1";
			$evento->confirmados = $rs->getObject($sql)->reservas;
			$sql = "SELECT IFNULL(SUM(anotado),0) as anotados FROM reservas WHERE eventos_idEvento=$id AND anotado =1";
			$evento->anotados = $rs->getObject($sql)->anotados;
			$sql = "SELECT IFNULL(SUM(cantLugares),0) as asistencia FROM reservas WHERE eventos_idEvento=$id AND asistencia =1";
			$evento->asistencia = $rs->getObject($sql)->asistencia;
		}

		return $eventos;
	}

	public static function getLatestEventos($search=false){
		$db=Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();
		$sql="SELECT eventos.*,tipos_evento.tipo,tipos_evento.nombre as nombretipo ,lugares.* FROM eventos,tipos_evento,lugares
		WHERE eventos.tipoEvento_idTipo = tipos_evento.idTipo
		AND lugares.idLugar = eventos.lugar_idLugar
		AND tipos_evento.tipo = 1";
		if($search != false){
			$sql.=" AND titulo LIKE '%$search%'";
		}
		$sql.=" ORDER BY eventos.date DESC
		LIMIT 100";
		//echo $sql;die;
		$eventos =  $rs->getObjects($sql);

		foreach ($eventos as $evento){
			$id = $evento->idEvento;
			$sql = "SELECT IFNULL(SUM(cantLugares),0)  as reservas FROM reservas WHERE eventos_idEvento=$id AND confirmado !=2";
			$evento->reservas = $rs->getObject($sql)->reservas;
			$sql = "SELECT IFNULL(SUM(cantLugares),0) as reservas FROM reservas WHERE eventos_idEvento=$id AND confirmado =1";
			$evento->confirmados = $rs->getObject($sql)->reservas;
			$sql = "SELECT IFNULL(SUM(anotado),0) as anotados FROM reservas WHERE eventos_idEvento=$id AND anotado =1";
			$evento->anotados = $rs->getObject($sql)->anotados;
			$sql = "SELECT IFNULL(SUM(cantLugares),0) as asistencia FROM reservas WHERE eventos_idEvento=$id AND asistencia =1";
			$evento->asistencia = $rs->getObject($sql)->asistencia;
		}

		return $eventos;
	}

	public static function getEvento($id){
		$db=Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();
		$sql="SELECT eventos.*,tipos_evento.tipo,tipos_evento.nombre as nombretipo ,lugares.lugar FROM eventos,tipos_evento,lugares
		WHERE eventos.idEvento = $id
		AND eventos.tipoEvento_idTipo = tipos_evento.idTipo
		AND tipos_evento.tipo = 1
		AND lugares.idLugar = eventos.lugar_idLugar
		";
		//echo $sql;die;
		$evento =  $rs->getObject($sql);
		//var_dump($evento);die;
		$id = $evento->idEvento;
		$sql = "SELECT IFNULL(SUM(cantLugares),0) as reservas FROM reservas WHERE eventos_idEvento=$id AND confirmado !=2";
		$evento->reservas = $rs->getObject($sql)->reservas;
		$sql = "SELECT IFNULL(SUM(cantLugares),0) as reservas FROM reservas WHERE eventos_idEvento=$id AND confirmado =1";
		$evento->confirmados = $rs->getObject($sql)->reservas;
		$sql = "SELECT IFNULL(SUM(anotado),0) as anotados FROM reservas WHERE eventos_idEvento=$id AND anotado =1";
		$evento->anotados = $rs->getObject($sql)->anotados;
		$sql = "SELECT IFNULL(SUM(cantLugares),0) as asistencia FROM reservas WHERE eventos_idEvento=$id AND asistencia =1";
		$evento->asistencia = $rs->getObject($sql)->asistencia;
		$sql = "SELECT * FROM campaings WHERE evento_idEvento=$id AND owners_idOwner =3";
		$evento->campescuela = $rs->getObject($sql);
		return $evento;
	}

	public static function getReservas($id){
		$db=Conexion::getConexion('usuarios');
		$rs=$db->getRecordset();
		$sql="SELECT * FROM reservas WHERE eventos_idEvento = $id ";  //no borrado  AND confirmado !=2

		//echo $sql;die;
		$reservas =  $rs->getObjects($sql);
		foreach ($reservas as $reserva){
			$id = $reserva->usuarios_idUsuario;
			$c = $reserva->camp_idCamp;
			$tipoUsuario = $reserva->tipoUsuario;
			if($tipoUsuario==1)$sql = "SELECT * FROM usuarios WHERE idUsuario = $id";
			else $sql = "SELECT * FROM falsos_usuarios WHERE idUsuario = $id";
			$reserva->usuario = $rs->getObject($sql);
			$sql="SELECT owners.nombre FROM campaings,owners
			WHERE idCamp = $c
			AND campaings.owners_idOwner = owners.idOwner
			";
			$reserva->owner = $rs->getObject($sql)->nombre;
			if(is_null($reserva->owner)){
				$c = $reserva->owners_idOwner;
				$sql="SELECT nombre FROM owners
				WHERE idOwner = $c";
				$reserva->owner = $rs->getObject($sql)->nombre;
			}
		}

		return $reservas;
	}

	public static function setEvento($params){

			$tipo = $params['tipoEvento'];
			$date = $params['fecha'];
			$titulo = htmlentities($params['titulo']);
			$subtitulo = htmlentities($params['subtitulo']);
			$fechaStr = htmlentities($params['fechaStr']);
			$horario = $params['horario'];
			$maxHorario = $params['maxHorario'];
			$idYoutube = $params['idYoutube'];
			$link = $params['link'];
			$texto = htmlspecialchars ($params['texto']); //strip_tags(htmlspecialchars_decode
			$activo = ( $params['activo'] == 'on' ? 1:0);
			$mostrarHome = ( $params['mostrarHome'] == 'on' ? 1:0);
			$mostrarAstro= ( $params['mostrarAstro'] == 'on' ? 1:0);
			$mostrarPsico= ( $params['mostrarPsico'] == 'on' ? 1:0);
			$lugar = $params['lugar'];
			$disponibilidad = $params['disponibilidad'];

			if(isset($params['idEvento'])){
				$sql = "UPDATE eventos SET
				tipoEvento_idTipo='$tipo',
				fecha=now(),
				date='$date',
				titulo='$titulo',
				subtitulo='$subtitulo',
				fechaStr='$fechaStr',
				horario='$horario',
				maxHorario='$maxHorario',
				idYoutube='$idYoutube',
				link='$link',
				texto='$texto',
				lugares='$disponibilidad',
				lugar_idLugar='$lugar',
				activo='$activo',
				mostrarHome='$mostrarHome',
				mostrarAstro='$mostrarAstro',
				mostrarPsico='$mostrarPsico'
				WHERE idEvento = ".$params['idEvento'];
			}
			else{
				$sql = "INSERT INTO eventos (tipoEvento_idTipo,fecha,date,titulo,subtitulo,fechaStr,horario,maxHorario,idYoutube,link,texto,lugares,lugar_idLugar,activo,mostrarHome,mostrarAstro,mostrarPsico)
					VALUES ('$tipo',now(),'$date','$titulo','$subtitulo','$fechaStr','$horario','$maxHorario','$idYoutube','$link','$texto','$disponibilidad','$lugar','$activo','$mostrarHome','$mostrarAstro','$mostrarPsico');";
			}

			try
			{
				echo $sql;
				$db = Conexion::getConexion('usuarios');
				$db->execute($sql);
				//return $estado;
			}
			catch (Exception $e) {
				$c = $e->getCode();
				throw new AppException("setEvento(): Error setEvento ($c):" . $e->getMessage(), 200);
			}
		if(isset($params['idEvento'])){
			return $params['idEvento'];
		}
		return self::lastId($db);;
	}

	public static function setCamp($idEvento){
		$sql = "INSERT INTO campaings (owners_idOwner,email,evento_idEvento) VALUES (3,'nicolas.nardi@aztlan.org.ar',$idEvento)";

		try
			{
				echo $sql;
				$db = Conexion::getConexion('usuarios');
				$db->execute($sql);
				//return $estado;
			}
			catch (Exception $e) {
				$c = $e->getCode();
				throw new AppException("setUsuario(): Error setCamp ($c):" . $e->getMessage(), 200);
			}
	}

	public static function setPresentismo($params){

		foreach ($params as $reserva){
			$presentismo = $reserva->presentismo;
			$id = $reserva->idReserva;
			$pago = $reserva->pago;
			$lugares = $reserva->lugares;
			$anotado = $reserva->anotado;

			$sql = "UPDATE reservas SET asistencia=$presentismo, pago=$pago, cantLugares=$lugares, anotado=$anotado WHERE idReserva=$id";
			try
			{
				//echo $sql;die;
				$db = Conexion::getConexion('usuarios');
				$db->execute($sql);
				//return $estado;
			}
			catch (Exception $e) {
				$c = $e->getCode();
				throw new AppException("setUsuario(): Error setPresentismo ($c):" . $e->getMessage(), 200);
			}
		}
		return true;
	}

	public static function setReservaEstado($params){
		$estado = $params->estado;
		$idReserva = $params->idReserva;

		$sql = "UPDATE reservas SET confirmado=$estado WHERE idReserva=$idReserva";

		try
		{
			$db = Conexion::getConexion('usuarios');
			$db->execute($sql);
			return $estado;
		}
		catch (Exception $e) {
			$c = $e->getCode();
			throw new AppException("setUsuario(): Error inesperado ($c):" . $e->getMessage(), 200);
		}
	}

	public static function setReserva($params){

		$nombre = escape($params->nombre);
		$apellido = escape($params->apellido);
		$dni = (property_exists($params, 'dni')) ? escape($params->dni) : '';
		$email = escape($params->email);
		$tel = escape($params->telefono);

		$tipo = escape($params->tipo);
		$owner = escape($params->owner);
		$source = escape($params->fuente);
		$addBase = escape($params->addBase);
		//var_dump($addBase);die;
		if(is_null($addBase))$addBase = 1;//para todos los formularios viejos, que reservan directo a la base de mailing
		$fecha = new Fecha();

		if($addBase == 1){
			$sql = "INSERT INTO usuarios (nombre,apellido,dni,email,telefono,tipo,source,owner,creado)
					VALUES (
					'$nombre','$apellido','$dni','$email','$tel','$tipo','formulario interno','$owner','$fecha')";

			try
			{
				$db = Conexion::getConexion('usuarios');
				$db->execute($sql);
			}
			catch (Exception $e) {
				$c = $e->getCode();
				if($c != 1062)throw new AppException("setUsuario(): Error inesperado ($c):" . $e->getMessage(), 200);
				else{
					$sql = "UPDATE usuarios SET
					nombre='$nombre',
					apellido='$apellido',
					dni='$dni',
					telefono='$tel'
					WHERE email='$email'";
					//echo $sql;die;
					try{
						$db->execute($sql);
					}catch (Exception $e) {
						throw new AppException("setUsuarioUPDATE(): Error inesperado ($c):" . $e->getMessage(), 200);
					}
				}
			}

			$usuario =  GET_camp::getUsuario($email);
			$idUsuario = $usuario->idUsuario;
		}
		else{ //addBAse = 0
			$sql = "INSERT INTO falsos_usuarios (nombre,apellido,dni,email,telefono)
					VALUES (
					'$nombre','$apellido','$dni','$email','$tel')";

			try
			{
				$db = Conexion::getConexion('usuarios');
				$db->execute($sql);
			}
			catch (Exception $e) {
				$c = $e->getCode();
				throw new AppException("setUsuario-noAddBase(): Error inesperado ($c):" . $e->getMessage(), 200);
			}

			$idUsuario = self::lastId($db);
		}

		$evento =  escape($params->idEvento);
		$lugares = escape($params->lugares);

		$sql = "INSERT INTO reservas (eventos_idEvento,usuarios_idUsuario,cantLugares,fecha,camp_idCamp,source,owners_idOwner,confirmado,tipoUsuario)
				VALUES (
				$evento,$idUsuario,$lugares,now(),0,$source,$owner,0,$addBase)";

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
}
?>
