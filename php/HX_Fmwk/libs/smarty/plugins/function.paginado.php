<?php

function smarty_function_paginado($params, & $smarty) {

	switch ($params['value']) {
		case "anterior":
			return intval(Paginado::tieneAnterior());
			break;
		case "siguiente":
			return intval(Paginado::tieneSiguiente());
			break;
		case "paginas":
			$r="";
			foreach (Paginado::paginasVisibles() as $x) {
				$r.="<span>$x</span>";
			}
			return $r;
			break;
		case "json":

			$ret=array();
			$ret["anterior"]=Paginado::tieneAnterior();
			$ret["siguiente"]=Paginado::tieneSiguiente();
			$ret["paginas"]=Paginado::paginasVisibles();
			$ret["pagina"]=Paginado::getPagina();
			return json_encode($ret);
			break;
		case "filas":
			return Paginado::getTotalFilas();
		default:
			$smarty->trigger_error("eval: missing 'value' parameter");
			break;
	}
}
?>
