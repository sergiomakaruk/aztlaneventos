<?php

include "../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

  	parent::addToSend(GET_site::getIdioma(), "idioma");
    parent::addToSend(GET_site::getSite(), "site");

    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>