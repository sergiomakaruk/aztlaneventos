<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {
	
  	DA_popup::setPopups($this->data->popups);
    parent::addToSend(DA_popup::getAll(), "popups");

    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>