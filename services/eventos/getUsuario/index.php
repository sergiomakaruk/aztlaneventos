<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

    parent::addToSend(GET_eventos::getUsuario($this->data->id),'usuario');

    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>
