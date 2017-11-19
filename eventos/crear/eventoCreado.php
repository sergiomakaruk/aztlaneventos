<?php
//error_reporting(E_ALL); 
//ini_set("display_errors", 1); 
//ini_set("display_startup_errors", 1); 


include "../../php/HX_Fmwk/load.php";

class Index extends AppPageController {

  public function onLoad() {	
  	 ob_clean();  	
	$idEvento = $_GET['idEvento'];
  	if(!is_null($idEvento)){
  		$evento = GET_eventos::getEvento($idEvento);
  		//var_dump($evento);
  		echo "cargar Fotos";
  		include('includes/upload.php');
  	}
  	else{
  		$this->errorLoadEvento();
  	}
  }
  
  private function errorLoadEvento(){
  	echo "El Evento no fue creado correctamente";
  }	
  
  public function onUnLoad() {}
  
}
Controller::load("Index");

?>