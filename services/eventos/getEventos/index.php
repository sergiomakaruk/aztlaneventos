<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

  	if($this->data->latest == true){
  		parent::addToSend(GET_eventos::getLatestEventos(),'eventos');
  	}
	else parent::addToSend(GET_eventos::getEventos(),'eventos');

    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>