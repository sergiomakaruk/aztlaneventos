<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {


    parent::addToSend(GET_section::getIdiomas(), "idiomas");
    parent::addToSend(GET_section::getIdioma(), "idioma");
    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>