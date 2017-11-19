<?php
abstract class AAppObject extends FWObject{

	protected  $imgLoad=false;
	protected $imgP="";
	protected $imgS=array();

	public final function getImage(){
		if(!$this->imgLoad) $this->loadImages();

		return $this->imgP;
	}
	public final function getImages($cant=null){
		if(!$this->imgLoad) $this->loadImages();

		if(is_null($cant)) return $this->imgS;

		return array_slice($this->imgS, 0,$cant);
	}

	private function loadImages(){
		$urlGet=Application::appKey("url").Application::appConfig("urlGallery")."get/?folder=".$this->getId();
		$a=json_decode(@file_get_contents($urlGet));

		if(!is_null($a)){
			if(count($a->gallery)>0){
				$this->imgP=$a->gallery[0];
			}
			for($x=1;$x<count($a->gallery);$x++){
				$this->imgS[]=$a->gallery[$x];
			}
		}
		$this->imgLoad=true;
	}
}
?>