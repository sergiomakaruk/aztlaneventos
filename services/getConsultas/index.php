<?php

include "../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

  	//PARAMS:------->
	  		//idCamp
		  	//source

	parent::addToSend(SET_consulta::getConsultas(),'consultas');

    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>