<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

	parent::addToSend(GET_eventos::getEvento($this->data->idEvento),'evento');

    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>