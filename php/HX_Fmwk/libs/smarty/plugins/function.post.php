<?php

function smarty_function_post($params, &$smarty){
	// be sure equation parameter is present
	if (empty($params['var'])) {
		$smarty->trigger_error("math: missing var parameter");
		return;
	}

	return $_POST[$params['var']];

}

?>