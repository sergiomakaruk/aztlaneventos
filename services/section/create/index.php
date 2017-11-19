<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {
  	
  	//PARAMS:------->
	  	//idSection == 0
	  	//active
	  	//name
	  	//toMainMenu
	  	//toMainName
	  	
  	$this->formatReferenceNameSection();
	parent::addToSend(SET_section::createSection($this->data),'section');
	//parent::addToSend(GET_section::getSection($this->data->idSection),'section');
	parent::addToSend(GET_section::getSite(),'site');
	GET_site::saveMenu();
    parent::send();
    
  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>