<?php

function smarty_modifier_normalize($string){

//	$search = explode(",","Á,É,Í,Ó,Ú,á,é,í,ó,ú");
//	$replace = explode(",","A,E,I,O,U,a,e,i,o,u");

	$search = explode(",","Ã¡,Ã©,Ã­,Ã³,Ãº,ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u");
	$replace = explode(",","a,e,i,o,u,c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u");


	return str_replace($search, $replace, $string);

}

/* vim: set expandtab: */

?>
