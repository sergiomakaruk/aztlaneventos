<?php

include "../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

  	if($this->data->active)GET_section::$onlyActives = true;

	//$_SESSION['idioma']

  	parent::addToSend(GET_section::getIdioma(), "idioma");
    parent::addToSend(GET_section::getSite(), "site");

    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>