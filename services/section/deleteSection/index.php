<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

  	//PARAMS:------->
	  	//idSection

	parent::addToSend(GET_section::getParent($this->data->id),'parent');
	parent::addToSend(SET_section::delete($this->data->id),'deleted');
	parent::addToSend(GET_section::getSite(),'site');
	GET_site::saveMenu();
    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>