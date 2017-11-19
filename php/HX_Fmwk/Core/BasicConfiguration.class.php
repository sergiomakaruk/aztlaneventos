<?php
class BasicConfiguration {

	private $values=array();

	public function value($name){
		return $this->values[$name];
	}

	public function __construct($config){
		$this->load($config);
	}
	private function load($config){
		$doc = new DOMDocument();
		$doc->load($config);
		$root = $doc->documentElement;
		$node = $root->firstChild;

		while ($node) {
			if (($node->nodeType == XML_ELEMENT_NODE) && ($node->nodeName == 'add')) {
				$name=$node->attributes->getNamedItem("name")->textContent;
				$value=$node->attributes->getNamedItem("value")->textContent;
				if(!is_null($name)){
					$this->values[$name]=$value;
				}
			}
			$node = $node->nextSibling;
		}
	}
}
?>