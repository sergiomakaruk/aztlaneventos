<?php
function smarty_function_concat($params, & $smarty) {

	if (!isset ($params['var'])) {
		$smarty->trigger_error("eval: missing 'var' parameter");
		return;
	}
	$s=":";
	if (isset ($params['separator'])) {
		$s=$params['separator'];
	}

	$ret="";
	foreach ($params['var'] as $v){
		$ret.="&nbsp;$v$s";
	}

	return substr($ret, 0, -1);

}
?>
