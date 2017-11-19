<?php
function smarty_modifier_iconv($string, $from="UTF-8", $to="ISO-8859-1"){
	return iconv($from, $to, $string);
}
?>