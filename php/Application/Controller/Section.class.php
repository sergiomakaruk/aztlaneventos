<?php

class Section  {

	public static $host;//"http://aztlan.org.ar/";
	public static $menuArticles;
	public static $selectedArticle;
	public static $section;
	public static $contents;
	public static $site;
	public static $extention = '.html';
	
	public function __construct(){
		//setSection devuelve un array con el path segun el menu [{seccion},{seccion},furl de articulo:String]
		//getContents
			//1 Se fija si hay que cargar el menu de articulos
			//2 carga el contenido de seccion si no es un articulo
			//3 carga el contenido de articulo si es articulo
			//4 pone al articulo en un array para que lo tome bien "articulo.php";
			//5 carga el path para los meta del articulo o seccion
	}
	
	public static function getContents(){
		//	var_dump(self::$section);die;	
		$cont = count(self::$section);
		$obj = new stdClass();		 
		
		if($cont>1 && self::$section[1]->showContent==1 || $cont>1){
			self::$menuArticles = GET_site::getMenuArticles(self::$section[1]->id,self::$section[1]->path);
		}
		
		if($cont<3){			
			$obj->contents = GET_site::getContentsBySection(self::$section[$cont-1]->id,self::$section[$cont-1]->path);
			$obj->path = self::$section[$cont-1]->path;
		}else
		{			
			foreach (self::$menuArticles as $articulo) 
			{				
				if(Section::$section[2] == $articulo->furl) self::$selectedArticle = $articulo;					
			}
						
			$obj->contents = array();
			$obj->contents[0] =GET_site::getContent(self::$selectedArticle->id,self::$section[1]->id,Section::$section[1]->path);			
			$obj->path = $obj->contents[0]->path;
		}
				
		//var_dump($obj);die;
		self::$contents = $obj;		
	}
	
	public static function getSite(){
		return self::$site;
	}
	
	public static function getTitle(){
		if(is_null(self::$contents))echo "404 Error";
		else echo utf8_decode(self::$contents->contents[0]->details->titulo);
	}
	
	public static function getHost(){
		echo self::$host;
	}
	public static function host(){
		return self::$host;
	}
	
	public static function getFbMeta(){
		//var_dump(Section::$contents->contents[0]->details);die;
		echo '<meta property="og:type" content="article" />';
		echo "\n";
		echo '<meta property="og:url" content="'. self::$host . self::$contents->path.Section::$extention. '" />';
		echo "\n";
		echo '<meta property="og:title" content="'.Section::$contents->contents[0]->details->titulo.'"/>';
		echo "\n";
		echo '<meta property="og:image" content="'. self::$host .'images/images/'. Section::$contents->contents[0]->img .'"/>';
		echo "\n";
		echo'<meta property="og:site_name" content="'.'Aztlan - Escuela de Psicología Y Filosofía'.'"/>';
		echo "\n";
		echo'<meta property="og:description" content="'. substr(strip_tags(base64_decode(Section::$contents->contents[0]->details->descripcion)),0,500) .'" />';
		echo "\n";
		
	}
	
	public static function resolveImgAlign($n){
	
		switch($n){
			case 0:return "img-left";
			case 1:return "img-middle";
			case 2:return "img-right";
			case 3:return "img-bottom";
			case 4:return "img-super-left";
			case 5:return "img-super-right";
		}
		
	}
	
	public static function shortArticle($text){
			$cant=1000;
			$hasToShort = ($cant < strlen($text)) ? true : false;
			$dots = ($hasToShort) ? "[...]" : "";			
			$cant = min($cant,strlen($text));
			$text = substr($text,0,$cant);			
			return $text.$dots;
			/*$text = $text.split('</p>');
			$text.pop();
			$text = $text.join('</p>');*/
			$result = new stdClass();
			$result->short = $hasToShort;
			$result->text = $text.$dots;
			return $result;
		}
		
	public static function getSocial($mini,$cont,$content){
		
		if($cont>1 && $mini==0 || $cont==1 && $mini==1)return '';
		
		$size = "24";
		$str = '<ul class="list-inline list-unstyled social-big">';
		if($cont>1){
			$size="16";
			$str = '<ul class="list-inline list-unstyled social-mini">';
		}
		$str.='<li> <a class="td-social-sharing-buttons td-social-twitter" href="https://twitter.com/intent/tweet?text='.urlencode($content->details->titulo).'&via=escuelaztlan&url='.urlencode(Section::host().$content->path.Section::$extention).'" onclick="window.open(this.href,' ."'". 'mywin'. "','". 'left=50,top=50,width=600,height=350,toolbar=0'."'".'); return false;"> <div class="td-sp td-sp-share-twitter"></div>	<div class="td-social-but-text">Twitter</div></a> </li>';
		$str.='<li> <a class="td-social-sharing-buttons td-social-facebook" href="https://www.facebook.com/sharer/sharer.php?u='.urlencode(Section::host().$content->path.Section::$extention).'" onclick="window.open(this.href,' ."'". 'mywin'. "','". 'left=50,top=50,width=600,height=350,toolbar=0'."'".'); return false;"> <div class="td-sp td-sp-share-facebook"></div>	<div class="td-social-but-text">Facebook</div></a> </li>';
		$str.='<li> <a class="td-social-sharing-buttons td-social-google" href="https://plus.google.com/share?url='.urlencode(Section::host().$content->path.Section::$extention).'" onclick="window.open(this.href,' ."'". 'mywin'. "','". 'left=50,top=50,width=600,height=350,toolbar=0'."'".'); return false;"> <div class="td-sp td-sp-share-google"></div>	<div class="td-social-but-text">Google +</div></a> </li>';
		
		$str.='</ul>';
		return $str;
	}

	
}
?>