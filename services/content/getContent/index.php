<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

  	//PARAMS:------->
	  		//idContent
		  	//idSection ( para el path )

	parent::addToSend(GET_content::getContent($this->data->idContent,$this->data->idSection),'content');

    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>