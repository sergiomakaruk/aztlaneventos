<?php

// 23/10/2008 21:45:11

function __autoload($class_name) {
	require_once $class_name . ".class.php";
}

function escape($value) {
	return addslashes(utf8Encode($value));
}

function utf8Encode($value){
	if(!mb_check_encoding($value,"utf8")){
		return utf8_encode($value);
	}
	return $value;
}

function utf8Decode($value){
	if(mb_check_encoding($value,"utf8")){
		return utf8_decode($value);
	}
	return $value;
}


function escapeUrl($string) {
	return rawurlencode(str_replace(array(" ","/",","), array("-","-","-"), $string));
}

function gestorExcepciones($excepcion) {
	echo $excepcion->getMessage(), "<br>";
}

function loadFrameworks(){
	foreach (loadXml(fmwkPath."load.xml") as $a) {
		$f=$a["name"];
		ini_set("include_path", phpIncludePath(loadXml(rootPath."$f/namespaces.xml","$f/")));

		if(file_exists(rootPath."$f/config.xml")){
			eval($f."::load(\"".rootPath."$f/config.xml\");");
		}
		if(!is_null($a["rewrite"])){
			$config=$_SERVER["DOCUMENT_ROOT"].$a["rewrite"];
			if(file_exists($config)){
				eval("$f::load(\$config);");
			}
		}
	}
}

function loadXml($xml, $pre=""){
	$ret=array();
	if(!file_exists($xml)){
		return $ret;
	}

	$doc = new DOMDocument();

	$doc->load($xml);
	$root = $doc->documentElement;
	$node = $root->firstChild;

	while ($node) {
		if (($node->nodeType == XML_ELEMENT_NODE) && ($node->nodeName == 'add')) {

			$name=$node->attributes->getNamedItem("name")->textContent;
			$rewrite=$node->attributes->getNamedItem("rewrite")->textContent;
			if(!is_null($name)){
				$ret[]=array(name=>$pre.$name, rewrite=>$rewrite);
			}
		}
		$node = $node->nextSibling;
	}

	return $ret;

}
function phpIncludePath($arrayPath){
	$ret=ini_get("include_path");

	foreach($arrayPath as $p){

		if(file_exists(rootPath.$p["name"])){
			$ret.=PATH_SEPARATOR.rootPath.$p["name"];
		}
	}
	return $ret;
}


//json under php 5.2
if (!function_exists('json_encode')) {
	require_once(libsPath."JSON/JSON.php");
}

function removeAccents($str) {
	$a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
	$b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
	return str_replace($a, $b, $str);
}

function toFurl($url){

    $url = removeAccents($url);
	//return $url;

	return strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $url), '-'));
}

function addFurl($sections,$parentFurl){
	$furl;
	if(is_array($sections))
	{
		foreach ($sections as $section)addFriendlyURL(true,$section,$section->details->name,$parentFurl);
	}
	else addFriendlyURL(true,$sections,$sections->details->name,$parentFurl);
}

function addContentFurl($content,$sectionpath){
	if(is_array($content))
	{
		foreach ($content as $cont)addFriendlyURL(false,$cont,$cont->details->titulo,$sectionpath,$cont->id);
	}
	else addFriendlyURL(false,$content,$content->details->titulo,$sectionpath,$content->id);
}

function addFriendlyURL($isSection,$obj,$name,$path,$idObj){
	if(is_null($name))$name = $obj->referenceName;
	$furl = toFurl($name);
	$obj->furl = $furl;

	if($isSection)
	{
		if(!is_null($path))$furl = $path.'/'.$furl;
	}
	else {
		$furl = '';
		if(!is_null($path))$furl = $path;//no deberia ser nunca null
		$furl.='/'.$obj->furl;
		//$furl.='?n='.$obj->furl;
		//if(!is_null($idObj))$furl.='&o='.$idObj;
	}

	$obj->path = $furl;
	
}

?>