<?php

function smarty_modifier_translate($string){
	return CultureInfo::translate($string);
}
?>