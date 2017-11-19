<?php
class AztlanPageController extends PageController {
	var $idioma = 1;
	public function __construct(){

		HX_Fmwk::registerApplication(Application::appKey("application"));
		parent::__construct();

	}
	
	public function onPreRender(){
	
		parent::onPreRender();
		if(!is_null($_SESSION['idioma']))$this->idioma = $_SESSION['idioma'];
		DA_Abs::$idIdioma = $this->idioma;
		
		Section::$host = "http://".$_SERVER['HTTP_HOST']."/";
		// echo gethostname();;die;
			//var_dump($_SERVER);die;
		#remove the directory path we don't want
		//$request  = str_replace("/", "", $_SERVER['REQUEST_URI']);
		$request = $_SERVER['REQUEST_URI'];
		
		//var_dump($request );
		//echo $request;
		#split the path by '/'
		
		//para el .html
		if(strrpos($request, ".")){
			$filebroken = explode( '.', $request);
			$extension = array_pop($filebroken);
			$request = implode('.', $filebroken);
		}	
		
		$params  = explode("/", $request);
		array_shift($params);
		if($params[0]=='')$params[0]='home';
		//echo "PARAMS 5";
		//var_dump($params);die;
					
		$safe_pages = array("home", "contactenos","contact-us","sitemap");
	ob_clean();
	
			$site = $this->getSite();
			Section::$site = $site;
			//var_dump($site);die;
			$section = $this->getSection($site,$params);
			//var_dump($section);die;
			//var_dump($site->site);die;
			if(count($section) > 0){
				Section::$section = $section;											
				Section::getContents();
			}
			
			
		if(in_array($params[0], $safe_pages)) {
			include($params[0].".php");
		} else {
			// articulos o videos o 404
			//buscar en menu variables
			// redireccionar a las tres opciones anteriores posibles			
			
			if(!count($section) > 0)include ('404.php');
			else {
				//Section::getContents();
				include("articulo.php");
			}
		}		
	}
	
	public function getTitle(){
		return utf8_decode(Section::$contents->contents[0]->details->titulo);
	}
	
	private function getSite(){	
		if(DA_Abs::$idIdioma == 2) return json_decode(utf8Encode(base64_decode(file_get_contents("menu64-en.txt"))));
		return json_decode(utf8Encode(base64_decode(file_get_contents("menu64.txt"))));
	}
	
	private function getSection($site,$route){
		//articulo es en realidad seccion...me confundo las secciones con el contenido articulo
		$seccionStr = $route[0];
		$seccion = null;
		$articulo=null;
		$result = array();
		if(count($route)>1)$articulo=$route[1];
		//var_dump($site);
		foreach ($site as $key => $value)
		{
			
			//var_dump($value);die;
			if($value->furl == $seccionStr)
			{
				$seccion = $value;
				$result[] = $value;
				//var_dump($articulo);die;
				if(!is_null($articulo))
				{
					foreach ($seccion->sections as $subkey => $subvalue)
					{
						//var_dump($subvalue);die;
						if($subvalue->furl == $articulo)
						{
							$result[] = $subvalue;
							if(count($route)>2)$result[]=$route[2];//agregamos en nombre del articulo
							/*if($subvalue->showContent == 1){
								var_dump($subvalue);die;
							}*/
							
							//$articulo = $subvalue;
							break;
						}
					}
				}
				break;
			}				
		}		
	
		//if(!is_null($articulo)) $seccion = $articulo;
		//var_dump($seccion);die;
		//var obj = {seccion:seccion.id,path:seccion.path};
		return $result;
	}
	
}
?>