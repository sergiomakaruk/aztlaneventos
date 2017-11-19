<?php


abstract class AppSerializableController extends PageSerializableController {


  /**
   *
   * @var int
   */
  var $idioma = 1;

  public function __construct() {
    parent::__construct();
/*
    $this->uid = FbContext::getUid();
    $this->usuario = DA::getUsuarioPorUid($this->uid);
*/
    if(!is_null($_SESSION['idioma']))$this->idioma = $_SESSION['idioma'];
    DA_Abs::$idIdioma = $this->idioma;
    //if(is_null($_SESSION['idioma']))$idIdioma
  }

  protected function trace($obj,$muere,$clean)
  {
  	if(!is_null($clean) && $clean== false) 'no clear';
  	else ob_clean();
  	var_dump($obj);
  	if(!is_null($muere) && $muere == false) 'no die';
  	else die;
  }

  protected function formatReferenceNameContent(){
  	if(!is_null($this->data->details->title))$this->data->rname =  toFurl($this->data->details->title);
  }

  protected function formatReferenceNameSection(){
  	if(!is_null($this->data->details->name))$this->data->rname =  toFurl($this->data->details->name);
  }
}
?>