<?php
//error_reporting(0);
include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

  	//PARAMS:------->
	  		//idCamp
		  	//source
		  	

	$camp = GET_camp::getCamp($this->data);
	parent::addToSend($camp,'camp');
	parent::addToSend(SET_camp::setEstadistica($camp),'estadistica');

    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>