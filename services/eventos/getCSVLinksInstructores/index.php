<?php

error_reporting(E_ALL); 
ini_set("display_errors", 1); 
ini_set("display_startup_errors", 1); 

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

  if($_GET['idEvento']){
	$idEvento = $_GET['idEvento'];
	$evt = GET_eventos::getEvento($idEvento);
	$fp = fopen( 'php://temp/maxmemory:'. (12*1024*1024) , 'r+' );
	
$db=Conexion::getConexion('usuarios');
$rs=$db->getRecordset();
$sql="SELECT idOwner,nombre FROM owners WHERE activo = 1 ";  
		//echo $sql;die;
		$owners =  $rs->getObjects($sql);		
	
		$thelink = "http://www.aztlan.org.ar/pages/";
		if($evt->tipoEvento_idTipo == '1')$thelink.="cineclub";
		else $thelink.="psi";
		$thelink.="/?c=".$idEvento.'/';
		//+owner+'/'+fuente;
		fputcsv( $fp, array('Nombre','FBMuro','FBImpulsar','EventoFB','Email','Adwords','Inbox'));
		foreach ($owners as $owner){
			//var_dump($evt);die;
			$owner->muro = $thelink.$owner->idOwner."/".'1';
			$owner->impulsar = $thelink.$owner->idOwner."/".'2';
			$owner->evento = $thelink.$owner->idOwner."/".'5';
			$owner->email = $thelink.$owner->idOwner."/".'6';
			$owner->adwords = $thelink.$owner->idOwner."/".'8';
			$owner->inbox = $thelink.$owner->idOwner."/".'9';
			
			fputcsv( $fp, array($owner->nombre,$owner->muro,$owner->impulsar,$owner->evento,$owner->email,$owner->adwords,$owner->inbox));
		}	
		ob_clean();
		//die;

	rewind( $fp );
	$output = stream_get_contents( $fp );
    $output = str_replace(",",";",$output); 
	fclose( $fp );

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=linksreservas_'. $idEvento .'.csv' ); 
	header('Content-Length: '. strlen($output) ); 
	echo $output; 
	exit;

}

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>