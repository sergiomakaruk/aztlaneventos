<?php

class GET_section extends DA_Abs{

	public static function getSite(){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		if(self::$onlyActives)//filtra por activos, y por secciones que tengan el detalle del idioma discriminado
		{
			$sql="SELECT sections.idSection as id,sections.sectionOrder
				FROM sections,section_details
				WHERE sections.level=0
				AND sections.idSection = section_details.sections_idSection
				AND section_details.active = 1
				AND section_details.idiomas_idIdioma = " . self::$idIdioma ."
				order by sections.sectionOrder";
		}
		else//todas las secciones de nivel 0
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
//die;
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
			 " order by sections.sectionOrder ASC, sections.idSection ASC";
		//echo $sql;die;
		$sections=$rs->getObjects($sql);

		return $sections;
	}

	public static function getSubSections($id,$furl){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		//$furl = self::getFurl($id);

		if(self::$onlyActives)//filtra por activos, y por secciones que tengan el detalle del idioma discriminado
		{
			$sql="SELECT sections.idSection as id,
			sections.sectionOrder,
			sections.level,
			sections.referenceName,
			sections.contentTypes_idType as type,
			sections.showContent
			FROM section_details,sections
			WHERE sections.idSection IN (SELECT subSection FROM section_relations WHERE parent = $id)
			AND section_details.sections_idSection = sections.idSection
			AND idiomas_idIdioma=". self::$idIdioma ."
			AND section_details.active=1";
			$sql.=" order by sections.sectionOrder ASC, sections.idSection DESC";
		}
		else
		{
			$sql="SELECT idSection as id,
				sectionOrder,
				level,
				referenceName,
				contentTypes_idType as type,
				showContent
				FROM sections
				WHERE idSection IN (SELECT subSection FROM section_relations WHERE parent = $id)";
				$sql.=" order by sectionOrder ASC, sections.idSection DESC";
		}

		try{
			$sections=$rs->getObjects($sql);
			//var_dump($sections);
			foreach ($sections as $section)$section->details = self::getDetails($section->id);
		}
		catch (Exception $e) {
			$c = $e->getCode();
			throw new AppException("Error getSubSections() ($c):" . $e->getMessage(), 200);
		}

		addFurl($sections,$furl);

		return $sections;
	}

	public static function getParent($idSection){
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql = "SELECT parent FROM section_relations WHERE subSection = '$idSection'";

		try{
			$parent = $rs->getObject($sql);
		}
		catch (Exception $e) {
			$c = $e->getCode();
			throw new AppException("Error getParent() ($c):" . $e->getMessage(), 200);
		}

		//var_dump($parent);die;
		if($parent)
		{
			try{
				$parent = $rs->getObject($sql);
			}
			catch (Exception $e) {
				$c = $e->getCode();
				throw new AppException("Error getParent() ($c):" . $e->getMessage(), 200);
			}

			return self::getSection($parent->parent);
		}

		return null;
	}

	public static function getHashSection($idSection){
		//esta funcion es igual a getSection, pero sin buscar las subsecciones
		//como las subsecciones no tienen servicio propio, dejo de usar esta funcion y le paso el parametro furl desde otra funcion
		// pero ahora la uso para get content
		//entonces la modifico y solo devuelve lo minimo para furl y path
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql="SELECT idSection as id,				
				level,
				referenceName			
				FROM sections
				WHERE sections.idSection = $idSection";

		try{
			$section  = $rs->getObject($sql);
			$section->details = self::getDetails($section->id);			
		}
		catch (Exception $e) {
			$c = $e->getCode();
			throw new AppException("Error getFurl() ($c):" . $e->getMessage(), 200);
		}
		//echo $sql;die;

		if($section->level != 0)
		{
			$parent = self::getParent($section->id);
			addFurl($section,$parent->furl);
		}
		else {
			addFurl($section);
		}

		return $section;
	}

	
	public static function getSection($idSection){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql="SELECT idSection as id,
				sectionOrder,
				level,
				referenceName,
				contentTypes_idType as type,
				showContent
				FROM sections
				WHERE sections.idSection = $idSection";

		try{
			$section  = $rs->getObject($sql);
			$section->details = self::getDetails($idSection);
		}
		catch (Exception $e) {
			$c = $e->getCode();
			throw new AppException("Error getSection() ($c):" . $e->getMessage(), 200);
		}
		//echo $sql;die;

		if($section->level != 0)
		{
			$parent = self::getParent($section->id);
			addFurl($section,$parent->furl);			
		}
		else {
			addFurl($section);
			$section->sections=self::getSubSections($section->id,$section->furl);
		}
		
		if($section->showContent == 1)$section->contents = GET_content::getContentsBySection($idSection);
		return $section;
	}

	public static function getDetails($id){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sqlDetails="SELECT
		name,
		toMainName,
		toMainMenu,
		active
		FROM section_details
		WHERE sections_idSection = $id
		AND idiomas_idIdioma=". self::$idIdioma ;

		return $rs->getObject($sqlDetails);
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

	public static function getIdiomas(){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql="SELECT * FROM idiomas";
		return $rs->getObjects($sql);
	}


}

?>