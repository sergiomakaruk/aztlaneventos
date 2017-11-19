<?php

class GET_content extends DA_Abs{


/*
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
	
*/
	public static function getCustomPopup(){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql="SELECT * FROM customPopup WHERE id = 1";
		//echo $sql;die;
		$content  = $rs->getObject($sql);

		return $content;
	}
	
	public static function getCustomHome(){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql="SELECT * FROM customHome WHERE id = 1";
		//echo $sql;die;
		$content  = $rs->getObject($sql);

		return $content;
	}


	public static function getContentsBySection($idSection){
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql = "SELECT
		contents.idContent as id,
		contents.contentTypes_idType as type,
		contents.referenceName,
		contents.img,
		contents.imgAlign,
		content_tosection.content_order as orden ";

		if(self::$onlyActives){
			$sql.="FROM content_details,contents,content_tosection
			WHERE content_details.contents_idContent = contents.idContent
			AND content_tosection.contents_idContent = contents.idContent
			AND content_tosection.sections_idSection = $idSection";
			$sql.=" AND content_details.idiomas_idIdioma=". self::$idIdioma ;
			$sql.=" AND content_details.activo=1";

		}
		else{

			$sql.="FROM contents,content_tosection
			WHERE content_tosection.contents_idContent = contents.idContent
			AND content_tosection.sections_idSection = $idSection";
		}

		$sql.=" ORDER BY content_tosection.content_order ASC, contents.idContent ASC";

		$contents  = $rs->getObjects($sql);


		foreach ($contents as $valor){
			$sql="SELECT
				titulo,
				descripcion,
				SEO_desc,
				activo
				FROM content_details
				WHERE contents_idContent = $valor->id
				AND content_details.idiomas_idIdioma=". self::$idIdioma ;
			//echo $sql;die;
				$valor->details = $rs->getObject($sql);
			}


		$sectionHash = GET_section::getHashSection($idSection);
		addContentFurl($contents,$sectionHash->path);

		return $contents;
	}

	public static function getContent($id,$idSection){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql="SELECT
				contents.idContent as id,
				contents.contentTypes_idType as type,
				contents.referenceName,
				contents.img,
				contents.imgAlign,
				content_tosection.content_order as orden
				FROM contents,content_tosection
				WHERE contents.idContent = $id
				AND content_tosection.contents_idContent = $id
				AND content_tosection.sections_idSection = $idSection";
		//echo $sql;die;
		$content  = $rs->getObject($sql);

		$sql="SELECT
		titulo,
		descripcion,
		SEO_desc,
		activo
		FROM content_details
		WHERE contents_idContent = $content->id
		AND content_details.idiomas_idIdioma=". self::$idIdioma ;
		$content->details = $rs->getObject($sql);

		$section = GET_section::getSection($idSection);
		addContentFurl($content,$section->path);

		return $content;
	}

	public static function getDetails($idContent){
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql="SELECT
		titulo,
		descripcion,
		SEO_desc,
		activo
		FROM content_details
		WHERE contents_idContent = $idContent
		AND idiomas_idIdioma=". self::$idIdioma ;

		return $rs->getObject($sql);
	}

}

?>