<?php

function smarty_modifier_toHtml($string)
{
	return htmlentities($string);
}
?>