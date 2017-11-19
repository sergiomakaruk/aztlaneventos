<?php
class Paginado {

	private static $filasVisibles=10;
	private static $pagina=1;
	private static $totalFilas=0;
	private static $init=false;

	public static function init() {
		if(Paginado::$init){
			return;
		}
		if(isset($_REQUEST["pag"])){
			Paginado::setPagina($_REQUEST["pag"]);
		}elseif(!is_null(Session::get("_pag_".md5(Server::SCRIPT_NAME())))){
			Paginado::setPagina(Session::get("_pag_".md5(Server::SCRIPT_NAME())));
		}
		if(isset($_REQUEST["vis"])){
			Paginado::setFilasVisibles($_REQUEST["vis"]);
		}elseif(!is_null(Session::get("_vis_".md5(Server::SCRIPT_NAME())))){
			Paginado::setFilasVisibles(Session::get("_vis_".md5(Server::SCRIPT_NAME())));
		}

		Session::set("_pag_".md5(Server::SCRIPT_NAME()),Paginado::$pagina);
		Session::set("_vis_".md5(Server::SCRIPT_NAME()),Paginado::$filasVisibles);

		Paginado::$init=true;
	}

	public static function setFilasVisibles($vis){
		Paginado::$filasVisibles=intval($vis);
		Session::set("_vis_".md5(Server::SCRIPT_NAME()),Paginado::$filasVisibles);
	}
	public static function getFilasVisibles(){
		Paginado::init();
		if(Paginado::$filasVisibles>0){
			return Paginado::$filasVisibles;
		}
		return 10;
	}
	public static function setPagina($pag){
		Paginado::$pagina=intval($pag);
		Session::set("_pag_".md5(Server::SCRIPT_NAME()),Paginado::$pagina);
	}
	public static function getPagina(){
		Paginado::init();
		if(Paginado::$pagina>0){
			return Paginado::$pagina;
		}
		return 1;
	}

	public static function setTotalFilas($totalFilas){
		Paginado::init();
		Paginado::$totalFilas=intval($totalFilas);
	}
	public static  function getTotalFilas() {
		Paginado::init();
		return Paginado::$totalFilas;
	}

	public static  function getTotalPaginas() {
		Paginado::init();
		return intval((Paginado::getTotalFilas() / Paginado::getFilasVisibles()) + (((Paginado::getTotalFilas() % Paginado::getFilasVisibles()) == 0) ? 0 : 1));
	}

	public static  function tieneSiguiente() {
		Paginado::init();
		return (Paginado::getTotalPaginas() > Paginado::getPagina());
	}

	public static  function tieneAnterior() {
		Paginado::init();
		return (Paginado::getPagina() > 1);
	}

	public static function filaInicio(){
		Paginado::init();
		$f=intval((Paginado::getPagina()- 1) * Paginado::getFilasVisibles());
		if($f>Paginado::getTotalFilas()){
			return 0;
		}
		return $f;
	}

	private static $paginasVisibles=10;

	public static function getPaginasVisibles() {
		return self::$paginasVisibles;
	}
	public static function setPaginasVisibles($paginasVisibles) {
		self::$paginasVisibles=$paginasVisibles;
	}



	public static function paginasVisibles($t=null){
		if(is_null($t)) $t=self::$paginasVisibles;

		Paginado::init();
		$r=array();
		if(Paginado::getTotalPaginas()<=$t){
			for($x=1;$x<=Paginado::getTotalPaginas();$x++){
				$r[]=$x;
			}
			return $r;
		}
		$ini=1;
		$fin=10;
		$pre=intval($t/2);
		if(Paginado::getPagina() > $pre){
			$ini=Paginado::getPagina()-$pre+1;
			$fin=$ini+$t-1;
		}
		if($fin>Paginado::getTotalPaginas()){
			$fin=Paginado::getTotalPaginas();
			$ini=$fin-$t+1;
		}
		for($x=$ini;$x<=$fin;$x++){
			$r[]=$x;
		}
		return $r;
	}
}
?>