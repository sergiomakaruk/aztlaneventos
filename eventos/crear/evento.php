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
  		$this->renderEvento($evento);
  	}
  	else{
  		$this->renderNewEvento();
  	}
  }

  private function renderEvento($evento){
  	//var_dump($evento);
  	//echo "EDIT Evento";
  	include('includes/form.php');
  }
  
	private function renderNewEvento(){
  		//echo "new Evento";
  		include('includes/form.php');
  }
  
  public function onUnLoad() {}
  
}
Controller::load("Index");

/*ALTER TABLE  `eventos` ADD  `fotoHome` VARCHAR( 1000 ) NOT NULL AFTER  `foto`*/
/*ALTER TABLE  `eventos` ADD  `mostrarHome` INT( 1 ) NOT NULL AFTER  `activo`*/
/*ALTER TABLE  `eventos` ADD  `idYoutube` VARCHAR( 250 ) NOT NULL AFTER  `fotoHome`*/
/*ALTER TABLE  `eventos` ADD  `horario` VARCHAR( 250 ) NOT NULL AFTER  `fechaStr`*/
/*ALTER TABLE  `eventos` ADD  `maxHorario` VARCHAR( 250 ) NOT NULL AFTER  `horario`*/
/*ALTER TABLE  `eventos` ADD  `link` VARCHAR( 1000 ) NOT NULL AFTER  `idYoutube`*/

/*GET_EVENTOS)*/
?>