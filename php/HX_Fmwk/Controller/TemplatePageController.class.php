<?php

abstract class TemplatePageController extends PageController{

	private $template;
	private $templateHTML=null;
	/*
	 * var int
	* segundos en los que expira la pagina
	*/
	protected $expires=0;

	public function __construct(){
		$this->pageType=PageType::template;
		$this->template=new Template(HX_Fmwk::getApplication());

		parent::__construct();
	}

	public function  assign($tpl_var,$value){
		$this->template->assign($tpl_var,$value);
	}

	public function  assignByRef($tpl_var,$value){
		$this->template->assign_by_ref($tpl_var,$value);
	}
	public function render($templateHTML){
		$this->templateHTML=$templateHTML;
	}

	public function onPreRender(){
		parent::onPreRender();
		if($this->expires>0){
			header('Pragma: public');
			header('Cache-Control: maxage='.$this->expires);
			header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$this->expires) . ' GMT');
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		}else{
			header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
			header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
			header('Pragma: no-cache');
			header('Cache-Control: no-cache, must-revalidate');
		}
		header('P3P: CP="NOI ADM DEV PSAi COM NAV OUR OTRo STP IND DEM"');
	}

	public function onRender() {
		if(is_null($this->templateHTML)) return;

		$this->assign("__IDIOMA__", CultureInfo::getIdioma()->getCodigo());
		$this->template->render($this->templateHTML);

		parent::onRender();
	}

	public function renderXML($templateXML){
		$this->render=false;
		$this->template->renderXML($templateXML);
		//parent::onRender();
	}
	public function renderPDF($templatePDF, $outputName="file.pdf"){
		$this->render=false;

		$html=$this->getContent($templatePDF);

		$pdf=new Pdf($this->template->compile_dir);
		$pdf->setHtml($html);

		$pdf->render();
		ob_end_clean();
		$pdf->stream($outputName);
	}
	public function getContent($template) {
		return $this->template->getContent($template);
	}

	public function saveAs($template, $path) {
		return  $this->template->saveAs($template, $path);
	}


	public function setTemplateDir($tplDir){
		$this->template->template_dir=$tplDir;
	}
	public function setCompileDir($cpDir){
		$this->template->compile_dir=$cpDir;
	}

	public function setCompileId($cpId){
		$this->template->compile_id=$cpId;
	}
	public function setMasterTemplate($template){
		$this->template->setMasterTemplate($template);
	}

	public function translate($tpl_var,$value){
		$this->assign($tpl_var, CultureInfo::translate($value));
	}


}
?>