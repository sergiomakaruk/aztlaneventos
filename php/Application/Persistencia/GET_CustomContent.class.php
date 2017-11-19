<?php

class GET_CustomContent extends DA_Abs{
	
	public static function getCustomContentById($id){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();
		$sql="SELECT * from customcontent WHERE id = $id";		
		return  $rs->getObject($sql);		
	}
	
	public static function getJsonContentById($id){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();
		$sql="SELECT content from customcontent WHERE id = $id";		
		return  json_decode($rs->getObject($sql)->content);		
	}
	
	public static function setCustomContent($id,$json){
		//var_dump($data);
		$json = escape($json);		
		$sql = "UPDATE customcontent SET
		content='$json'			
		WHERE id = $id";

		try
		{
			$db = Conexion::getConexion();
			$db->execute($sql);			

			return true;
		}
		catch (Exception $e) {
			$c = $e->getCode();
			throw new AppException("Error setCustomContent ($c):" . $e->getMessage(), 200);
		}		
	}

}

?>