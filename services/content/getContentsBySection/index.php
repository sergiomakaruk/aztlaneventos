<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {
  	
  	//PARAMS:------->	    		
		  //idSection   
  	if($this->data->active)GET_content::$onlyActives = true;
  	
	parent::addToSend(GET_content::getContentsBySection($this->data->idSection),'contents');
	
    parent::send();
    
  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>