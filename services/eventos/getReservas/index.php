<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

	parent::addToSend(GET_eventos::getReservas($this->data->idEvento),'reservas');

    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>