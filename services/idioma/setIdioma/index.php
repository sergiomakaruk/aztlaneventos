<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {
	$idioma = GET_section::getIdiomaByStr($this->data->idioma);
	$_SESSION['idioma'] = $idioma->idIdioma;
    parent::addToSend(GET_section::getIdioma(), "idioma");
    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>