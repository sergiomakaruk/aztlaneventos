<?php

function smarty_function_request($params, &$smarty){
	// be sure equation parameter is present
	if (empty($params['var'])) {
		$smarty->trigger_error("math: missing var parameter");
		return;
	}

	return $_REQUEST[$params['var']];

}

?>