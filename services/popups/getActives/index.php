<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

    parent::addToSend(DA_popup::showPopup(), "popup");
     parent::addToSend(GET_section::getIdioma(), "idioma");
	$_SESSION['popup']=true;
    parent::send();
	
  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>