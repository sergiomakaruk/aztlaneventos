<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

    parent::addToSend(GET_eventos::setUsuario($this->data->id,$this->data->estado,$this->data->txt),'usuario');

    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>
