<?php

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {translate} function plugin
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
function smarty_function_translate($params, & $smarty) {

	if (!isset ($params['var'])) {
		$smarty->trigger_error("eval: missing 'var' parameter");
		return;
	}
	if (isset ($params['type'])) {
		return CultureInfo::translate($params['var'], $params['type']);
	}
	return CultureInfo::translate($params['var']);

}

/* vim: set expandtab: */
?>
