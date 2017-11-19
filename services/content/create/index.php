<?php

include "../../../php/HX_Fmwk/load.php";

class Index extends AppSerializableController {

  public function onLoad() {

  	//PARAMS:------->
	  		//title
		  	//active
		  	//description
		  	//img
		  	//thumb
		  	//align
		  	//order
		  	//idSection
	//var_dump(phpinfo());
	//echo ini_get("max_input_vars");
	//var_dump($POST);
	//echo $this->data->details->active;
	//echo $this-data->img;
	//echo '</br>';
  	//var_dump($this->data);die;

  	$newContent = is_null($this->data->id);
  	$this->data->pathImg = null;

  	if(!$newContent && $this->data->img){
  		//update
  		//$content = GET_content::getContent($this->data->id,$this->data->idSection);

  		//para q no subreescriba el nombre segun la imagen
  		$title = $this->data->details->title;
  		$this->data->details->title = $this->data->referenceName;
  		$this->formatReferenceNameContent();
  		$this->data->pathImg = $this->data->rname ."_". $this->data->id . ".jpg";
  		$this->data->details->title = $title;
  	}
  	else
  	{
  		$this->formatReferenceNameContent();
  	}

  	if(!$newContent){
  		parent::addToSend(SET_content::updateContent($this->data),'content');
  	}
	else{
		$content = SET_content::createContent($this->data);
		parent::addToSend($content,'content');
	}

  	if($this->data->img)
  	{
  		//$this->data->pathImg = $this->data->rname ."_". $content->id . ".jpg";// si es nuevo..la variable se formatea en la consulta,sino se formatea arriva
  		//parent::trace($img);
  		$img = $this->data->pathImg;
  		if (@file_put_contents("../../../images/images/$img", @base64_decode($this->data->img))) {
  			parent::addToSend($img,'img');
  		} else {
  			throw new AppException("Error en subir la imagen", 105);
  		}

  		if (@file_put_contents("../../../images/thumbs/$img", @base64_decode($this->data->thumb))) {
  			//parent::addToSend($img,'img');
  		} else {
  			throw new AppException("Error en subir el thumb", 105);
  		}
  	}


	//parent::addToSend(GET_section::getSection($this->data->idSection),'section');
	parent::addToSend(GET_section::getSite(),'site');
    parent::send();

  }

  public function onUnLoad() {}
}
Controller::load("Index");

?>