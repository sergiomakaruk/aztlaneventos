<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {
  	
  	//PARAMS:------->
	  	//secciones {id:n,order:n}	  	

	parent::addToSend(SET_section::changeOrder($this->data->secciones),'orderChanged');
	parent::addToSend(GET_section::getSite(),'site');
	GET_site::saveMenu();
    parent::send();
    
  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>