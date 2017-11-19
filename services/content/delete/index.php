<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {
  	
  	//PARAMS:------->	  	
	  		//idContent		 	
  	
	parent::addToSend(SET_content::delete($this->data->idContent),'content');
	
    parent::send();
    
  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>