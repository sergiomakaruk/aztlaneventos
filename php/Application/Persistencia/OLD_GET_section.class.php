<?php

class GET_section extends DA_Abs{


	public static function getSite(){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		if(self::$onlyActives)
		{
			$sql="SELECT sections.idSection as id,sections.sectionOrder
				FROM sections,section_details
				WHERE sections.level=0
				AND sections.idSection = section_details.sections_idSection
				AND section_details.active = 1
				AND section_details.idiomas_idIdioma = " . self::$idIdioma ."
				order by sections.sectionOrder";
		}
		else
		{
			$sql="SELECT idSection as id,sectionOrder
				FROM sections
				WHERE level=0
				order by sectionOrder";
		}
		//echo $sql;die;

		$site=$rs->getObjects($sql);

		$rsite = array();
		foreach ($site as $valor)$rsite[] = self::getSection($valor->id);

		return $rsite;
	}

	public static function getOrders($id){
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql="SELECT sections.idSection as id,
		sections.sectionOrder,
		section_details.name
		FROM section_details,sections";

		$section = self::getSection($id);
		if($section->level == 0)
		{
			$sql.=" WHERE section_details.sections_idSection = sections.idSection
			AND sections.level = 0 ";
		}
		else
		{
			$parent = self::getParent($id)->id;
			$sql.=" WHERE sections_idSection IN (SELECT subSection FROM section_relations WHERE parent = $parent)
			AND section_details.sections_idSection = sections.idSection ";
		}

		$sql.="AND idiomas_idIdioma=". self::$idIdioma .
			 " order by sections.sectionOrder";
		//echo $sql;die;
		$sections=$rs->getObjects($sql);

		return $sections;
	}

	public static function getSubSections($id){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$furl = self::getFurl($id);

		$sql="SELECT sections.idSection as id,
		sections.sectionOrder,
		sections.referenceName,
		section_details.name,
		section_details.toMainMenu,
		section_details.active,
		sections.contentTypes_idType as type
		FROM section_details,sections
		WHERE sections_idSection IN (SELECT subSection FROM section_relations WHERE parent = $id)
		AND section_details.sections_idSection = sections.idSection
		AND idiomas_idIdioma=". self::$idIdioma ;
		if(self::$onlyActives)$sql.=" AND section_details.active=1";
		$sql.=" order by sections.sectionOrder";

		$sections=$rs->getObjects($sql);
		addFurl($sections,$furl);

		return $sections;
	}

	public static function getParent($idSection){
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql = "SELECT parent FROM section_relations WHERE subSection = '$idSection'";
		$parent = $rs->getObject($sql);
		//var_dump($parent);die;
		if($parent)
		{
			return self::getSection($parent->parent);
		}

		return null;
	}

	public static function getFurl($idSection){
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql="SELECT section_details.name
				FROM section_details,sections
				WHERE section_details.sections_idSection = sections.idSection
				AND section_details.idiomas_idIdioma=". self::$idIdioma . "
				AND sections.idSection = $idSection	";

		$section  = $rs->getObject($sql);
		addFurl($section);		;
		return $section->furl;
	}

	public static function getSection($idSection){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql="SELECT sections.idSection as id,
				sections.sectionOrder,
				sections.level,
				sections.referenceName,
				section_details.name,
				section_details.toMainName,
				section_details.toMainMenu,
				section_details.active,
				sections.contentTypes_idType as type
				FROM section_details,sections
				WHERE section_details.sections_idSection = sections.idSection
				AND section_details.idiomas_idIdioma=". self::$idIdioma . "
				AND sections.idSection = $idSection	";

		$section  = $rs->getObject($sql);

		if($section->level != 0)
		{
			$parent = self::getParent($section->id);
			//$sql = "SELECT parent FROM section_relations WHERE subSection = '$section->id'";
			//$parentFurl = toFurl(self::getSection($rs->getObject($sql)->parent)->name);
			addFurl($section,$parent->furl);
		}
		else {
			addFurl($section);
			$section->sections=self::getSubSections($section->id);
		}

		return $section;
	}

	public static function getIdiomaByStr($str){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql="SELECT * FROM idiomas WHERE idioma='$str'";
		return $rs->getObject($sql);
	}

	public static function getIdioma(){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql="SELECT * FROM idiomas WHERE idIdioma= " . self::$idIdioma ;
		return $rs->getObject($sql);
	}

}

?>