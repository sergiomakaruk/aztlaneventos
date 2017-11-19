<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

	parent::addToSend(GET_eventos::setPresentismo($this->data->presentismo),'presentismo');

    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>