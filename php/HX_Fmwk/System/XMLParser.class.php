<?php

// 27/10/2008 15:31:08
// hugo@hexium.com.ar

class XMLParser{

	private $doc;
	private $root;

	public function __construct(){
		$this->doc=new DOMDocument();
	}

	public function load($value){
		@$this->doc->load($value);
		$this->root=$this->doc->documentElement;
		if(is_null($this->root)){
			throw new Exception("XMLParser::load el archivo \"$value\" XML no se cargo");
		}
	}

	public function isLoaded(){
		return (is_null($this->root))?false:true;
	}

	public function getNodes (){
		$ret=array();
		foreach($this->root->childNodes as $node){
			if($node->nodeType==XML_ELEMENT_NODE){
				$ret[]=new XMLNode($node);
			}
		}
		return $ret;
	}

}

class XMLNode{
	var $node;

	public function __construct(DOMElement $value){
		$this->node=$value;
	}

	public function getNodes (){
		$ret=array();
		foreach($this->node->childNodes as $node){
			if($node->nodeType==XML_ELEMENT_NODE){
				$ret[]=new XMLNode($node);
			}
		}
		return $ret;
	}
	public function nodeName(){
		return $this->node->nodeName;
	}
	public function nodeValue(){
		return $this->node->nodeValue;
	}
	public function getAttribute($value){
		return $this->node->getAttributeNode($value)->value;
	}
	public function hasAttribute($value){
		return $this->node->hasAttribute($value);
	}

}

?>