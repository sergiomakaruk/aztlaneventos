<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

  	//PARAMS:------->
	  	//idSection

	parent::addToSend(GET_section::getOrders($this->data->id),'orders');

    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>