<?php

function smarty_function_get($params, &$smarty){
	// be sure equation parameter is present
	if (empty($params['var'])) {
		$smarty->trigger_error("math: missing var parameter");
		return;
	}

	return $_GET[$params['var']];

}

?>