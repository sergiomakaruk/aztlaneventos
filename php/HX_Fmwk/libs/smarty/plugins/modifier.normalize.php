<?php

function smarty_modifier_normalize($string){

//	$search = explode(",","�,�,�,�,�,�,�,�,�,�");
//	$replace = explode(",","A,E,I,O,U,a,e,i,o,u");

	$search = explode(",","á,é,í,ó,ú,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,�,e,i,�,u");
	$replace = explode(",","a,e,i,o,u,c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u");


	return str_replace($search, $replace, $string);

}

/* vim: set expandtab: */

?>
