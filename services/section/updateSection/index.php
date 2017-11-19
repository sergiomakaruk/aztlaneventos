<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

  	//PARAMS:------->
	  	//idSection
	  	//active
	  	//name
	  	//toMainMenu
	  	//toMainName

  	$this->formatReferenceNameSection();
	parent::addToSend(SET_section::updateSection($this->data),'update');
	parent::addToSend(GET_section::getSection($this->data->id),'section');
	parent::addToSend(GET_section::getSite(),'site');
	GET_site::saveMenu();
    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>