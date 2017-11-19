<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {
  	
  	//PARAMS:------->	  	
	  		//idContent
		  	//idSection ( para el path ) 	  	
  	$section = GET_site::getSection($this->data->idSection);
  	parent::addToSend($section,'section');
  	parent::addToSend(GET_site::getParent($this->data->idSection),'parent');
	parent::addToSend(GET_site::getContent($this->data->idContent,$this->data->idSection,$section->path),'content');
	
    parent::send();
    
  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>