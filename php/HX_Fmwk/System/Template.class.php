<?php

// 25/11/2008 15:12:28
// hugo@hexium.com.ar

//define(pathTemplates,rootPath.Configuration::appConfig("pathTemplates"));
//define(pathTemplates_c,rootPath.Configuration::appConfig("pathTemplates_c"));

include(libsPath."smarty/Smarty.class.php");

class Template extends Smarty {

	protected $masterTemplate=null;
	protected $application="";

	public function __construct($app=null){
		if(is_null($app)){
			$app=HX_Fmwk::getApplication();
		}

		$this->application=$app;
		$this->template_dir=(is_null($this->template_dir))?rootPath.Configuration::appConfig("pathTemplates"):$this->template_dir;
		$this->compile_dir=(is_null($this->compile_dir))?rootPath.Configuration::appConfig("pathTemplates_c"):$this->compile_dir;
		$this->compile_id=(is_null($this->compile_id))?"":$this->compile_id;
	}

	public function render($template) {
		ob_start();
		if(substr($template, 0,2)=="./"){
			$this->template_dir=dirname($_SERVER["SCRIPT_FILENAME"]).DIRECTORY_SEPARATOR;
			//$this->template_dir=dirname(Server::DOCUMENT_ROOT().Server::SCRIPT_NAME()).DIRECTORY_SEPARATOR;
		}
		if(is_null($this->masterTemplate)){
			parent :: display($template);
		}else{

			$this->assign("__TEMPLATE__",$template);
			parent :: display($this->masterTemplate);
		}
		$miHtml = ob_get_contents();
		ob_end_clean();
		$js=JScript::render();
		if($js!=""){
			$c=0;
			$miHtml=str_replace("<head>",$js."<head>", $miHtml,$c);
			if($c==0){
				$miHtml=$js.$miHtml;
			}
		}

		echo $miHtml;
	}

	public function renderXML($template){
		//header_remove();
		header ("content-type: text/xml", true);
		parent :: display($template);
	}

	public function getContent($template) {
		ob_start();
		Template::render($template);
		$miHtml = ob_get_contents();
		ob_end_clean();

		return $miHtml;

	}

	public function saveAs($template, $path) {
		@ unlink($path);
		if (!$gestor = fopen($path, "a")) {
			return false;
		}
		if (!fwrite($gestor, Template::getContent($template))) {
			return false;
		}
		return true;
	}

	public function setTemplateDir($tplDir){
		$this->template_dir=$tplDir;
	}
	public function setCompileDir($cpDir){
		$this->compile_dir=$cpDir;
	}
	public function setCompileId($cpId){
		$this->compile_id=$cpId;
	}
	public function setMasterTemplate($template){
		$this->masterTemplate=$template;
	}

}

?>