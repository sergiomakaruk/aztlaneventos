<?php

class DA_popup extends DA_Abs{
	
public static function getAll(){
	
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql="SELECT * 
		FROM popups
		WHERE nombre != 'ULTIMA'";
		
	//	echo $sql;die;
		
		$popups  = $rs->getObjects($sql);
		return $popups;		 
	}
	
public static function showPopup(){
	
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql="SELECT * 
		FROM popups
		WHERE active = 1";
		
		$popups  = $rs->getObjects($sql);
		
		if(count($popups) > 1){
			//si hay varios activos, traigo el ultimo y seteo como visto
			
			//ultimo visto
			$sql="SELECT * 
				FROM popups
				WHERE popupType IN (SELECT popupType FROM popups WHERE nombre = 'ULTIMA')";
			
			$popup  = $rs->getObject($sql);
			$id = $popup->idPopup;
			
			$sql="SELECT * 
				FROM popups
				WHERE idPopup !=$id AND nombre != 'ULTIMA' AND active=1" ;
			
			$popups  = $rs->getObjects($sql);
			//var_dump($popups);die;
			
			foreach ($popups as $pop){
				if($pop->idPopup == ($id+1))$popup=$pop;
				else $popup = $popups[0];
			}
			//grabo como ultimo
			$id = $popup->idPopup;			
			$sql="UPDATE popups SET popupType=$id WHERE nombre = 'ULTIMA'";
			$db->execute($sql);
			
			return $popup;	
		}
		else return $popups[0];		 
	}
	
public static function setPopups($data){
		$db=Conexion::getConexion();
		//$rs=$db->getRecordset();
		
		foreach ($data as $popup){			
			$sql="UPDATE popups SET active=".$popup->active." ,delay=".$popup->delay." ,traker='".$popup->traker."' WHERE idPopup=".$popup->idPopup;
			//echo $sql;die;	
			$db->execute($sql);
		}		

		return true;
	}	
}

?>