<?php
abstract class FWObject extends Object implements IFWObject {

	protected $id=0;
	protected $habilitado=false;
	protected $eliminado=false;
	protected $fechaCreado=null;
	protected $fechaModificado=null;

	public function setId($id){
		$this->id=intval($id);
	}
	public function getId(){
		return $this->id;
	}

	public function setHabilitado($habilitado){
		$this->habilitado=(boolean) $habilitado;

	}
	public function getHabilitado(){
		return ($this->habilitado)?1:0;
	}

	public function setEliminado($eliminado){
		$this->eliminado=(boolean) $eliminado;
	}
	public function getEliminado(){
		return ($this->eliminado)?1:0;
	}

	public function setFechaCreado($fecha){
		$this->fechaCreado=$fecha;
	}
	public function getFechaCreado($format=null){
		if(is_null($format)){
			return $this->fechaCreado;
		}
		return $this->fechaCreado->format($format);
	}

	public function setFechaModificado($fecha){
		$this->fechaModificado=$fecha;
	}
	public function getFechaModificado($format=null){
		if(is_null($format)){
			return $this->fechaModificado;
		}
		return $this->fechaModificado->format($format);
	}


}
?>