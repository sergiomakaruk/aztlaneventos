<?php

include "../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {


  	parent::addToSend(DA_img::setFoto($this->data), "imagen");
   
    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>