<?php

error_reporting(E_ALL); 
ini_set("display_errors", 1); 
ini_set("display_startup_errors", 1); 

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

  if($_GET['idEvento']){
	$idEvento = $_GET['idEvento'];
	//$fecha = $_GET['fecha'];

	$fp = fopen( 'php://temp/maxmemory:'. (12*1024*1024) , 'r+' );

$db=Conexion::getConexion('usuarios');
$rs=$db->getRecordset();
$sql="SELECT * FROM reservas WHERE eventos_idEvento = $idEvento ";  //no borrado  AND confirmado !=2
		
		//echo $sql;die;
		$reservas =  $rs->getObjects($sql);		
		//var_dump($reservas);die;
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
			
			$nombre = $reserva->usuario->nombre;
			$apellido = $reserva->usuario->apellido;
			$email = $reserva->usuario->email;
			$telefono = $reserva->usuario->telefono;
			$source = $reserva->owner;
			$idReserva = $reserva->idReserva;
			
			
			
			fputcsv( $fp, array($apellido,$nombre,'','',$email,$telefono,$source,$idReserva));
		}	
		ob_clean();
		//die;

	rewind( $fp );
	$output = stream_get_contents( $fp );
    $output = str_replace(",",";",$output); 
	fclose( $fp );

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=reservas_'. $idEvento .'.csv' ); 
	header('Content-Length: '. strlen($output) ); 
	echo $output; 
	exit;

}

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>