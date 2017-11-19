<?php

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {selected} function plugin
 *
 * Type:     function<br>
 * Name:     translate<br>
 * Purpose:  traducir una palabra en tiempo de ejecucion<br>
 * @link http://smarty.php.net/manual/en/language.function.eval.php {eval}
 *       (Smarty online manual)
 * @author Hugo Vazquuez <hugo at hexium dot com dot ar>
 * @param array
 * @param Smarty
 */
function smarty_function_selected($params, & $smarty) {

	if (!isset ($params['name']) ||!isset ($params['value'])  ) {
		$smarty->trigger_error("eval: missing 'var' or 'value' parameter");
		return;
	}

	return ($_REQUEST[$params['name']]==$params['value'])?"selected":"";

}

/* vim: set expandtab: */
?>
