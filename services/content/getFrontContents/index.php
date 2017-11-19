<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {
  	
  	//PARAMS:------->	    		
		  //idSection   
		 
  	$section = GET_site::getSection($this->data->idSection);
  	parent::addToSend($section,'section');
  	parent::addToSend(GET_site::getParent($this->data->idSection),'parent');
	parent::addToSend(GET_site::getContentsBySection($this->data->idSection,$section->path),'contents');
	
    parent::send();
    
  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>