<?php

include "../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

  	$section = GET_site::getSection($this->data->idSection);
  	parent::addToSend($section, "section");
    parent::addToSend(GET_site::getMenuArticles($this->data->idSection,$section->path), "contents");

    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>