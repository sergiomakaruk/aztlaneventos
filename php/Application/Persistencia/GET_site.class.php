<?php

class GET_site extends DA_Abs{
	
	public static function saveMenu(){
		$currentIdioma = self::$idIdioma;
		self::$idIdioma = 1;
		$myfile = fopen("../../../menu64.txt", "w") or die("Unable to open file!");
		$json = base64_encode(@json_encode(self::getSite()));
		fwrite($myfile, $json);		
		fclose($myfile);
		self::$idIdioma = 2;
		$myfile = fopen("../../../menu64-en.txt", "w") or die("Unable to open file!");
		$json = base64_encode(@json_encode(self::getSite()));
		fwrite($myfile, $json);
		fclose($myfile);
		
		self::$idIdioma = $currentIdioma;
	}

	public static function getSite(){

		$db=Conexion::getConexion();
		$rs=$db->getRecordset();
		
		$sql="SELECT sections.idSection as id,
		sections.sectionOrder,
		sections.level,
		sections.referenceName,
		sections.contentTypes_idType as type,
		sections.showContent,
		section_details.name,
		section_details.toMainName,
		section_details.toMainMenu
		FROM section_details,sections
		WHERE section_details.sections_idSection = sections.idSection
		AND idiomas_idIdioma=". self::$idIdioma ."
		AND section_details.active=1";
		$sql.=" order by sections.level ASC ,sections.sectionOrder ASC, sections.idSection DESC";			

		$site=$rs->getObjects($sql);

		$rsite = array();
		foreach ($site as $valor){
			if($valor->level == 0){
				$nsec = self::formatObj($valor);
				$nsec->sections = array();
				addFurl($nsec);
				$subs = self::subs($nsec->id);
				
				foreach ($subs as $idSub){
					
					foreach ($site as $subsect){
						
						if($subsect->id == $idSub->subSection){
							$nsubsect = self::formatObj($subsect);
							addFurl($nsubsect,$nsec->path);
							$nsec->sections[] = $nsubsect;
						}
					}
				}
				
				$rsite[] = $nsec;
			}
			
		}
//die;
		return $rsite;
	}
	private static function subs($id){
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();
		$sql="SELECT subSection FROM section_relations WHERE parent = $id";
		return $rs->getObjects($sql);
	}
	private static function formatObj($obj){
		$nobj = new stdClass();
		$details = new stdClass();
		foreach ($obj as $key => $valor){
			if($key != 'name' && $key != 'toMainName' && $key != 'toMainMenu' && $key != 'titulo' && $key != 'descripcion'){
				$nobj->$key=$valor;
			}
			else{
				$details->$key=$valor;
			}	
		}
		$nobj->details = $details;
		return $nobj;
	}

	public static function getSection($idSection){
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();
		
		$sql="SELECT 
		sections.idSection,
		sections.level,
		sections.showContent,
		section_details.name		
		FROM section_details,sections
		WHERE section_details.sections_idSection = $idSection
		AND section_details.sections_idSection = sections.idSection
		AND section_details.idiomas_idIdioma=". self::$idIdioma ;
				
		$result = $rs->getObject($sql);
		
		if($result->level != 0){
			$parent = self::getParent($result->idSection);				
		}
		//echo $sql;die;
		$section = new stdClass();
		$section->details = $result;
		if($parent)addFurl($section,$parent->path);
		else addFurl($section);
		
		return $section;
	}
	
	public static function getParent($id){
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();
		
		$sql="SELECT 
				section_details.name
				FROM section_details,section_relations
				WHERE section_relations.subSection =". $id;
			$sql.=" AND section_details.sections_idSection =  section_relations.parent";
		
		$result = $rs->getObject($sql);
		if(is_null($result))return null;
		
		$parent = new stdClass();
		$parent->details = $result;	
		addFurl($parent);	

			return $parent;
	}
	public static function getMenuArticles($idSection,$path){
		
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();		

		$sql = "SELECT	
		contents.idContent as id,
		contents.contentTypes_idType as type,
		content_details.titulo,					
		content_tosection.content_order as orden 
		FROM contents,content_details,content_tosection
		WHERE content_details.contents_idContent = contents.idContent
		AND content_tosection.contents_idContent = contents.idContent
		AND content_tosection.sections_idSection = $idSection";			
			
		$sql.=" AND content_details.idiomas_idIdioma=". self::$idIdioma ;
		$sql.=" AND content_details.activo=1";
		$sql.=" ORDER BY content_tosection.content_order ASC, contents.idContent ASC";

		$contents  = $rs->getObjects($sql);
		$ncontents = array();
		foreach ($contents as $cont){
			$ncont = self::formatObj($cont);
			addContentFurl($ncont,$path);
			$ncontents[] = $ncont;			
		}	

		return $ncontents;
	}
	
	public static function getContentsBySection($idSection,$path){
		$db=Conexion::getConexion();
		$rs=$db->getRecordset();

		$sql = "SELECT
		contents.idContent as id,
		contents.contentTypes_idType as type,
		contents.referenceName,
		contents.img,
		contents.imgAlign,
		content_tosection.content_order as orden ";

		
		$sql.="FROM content_details,contents,content_tosection
		WHERE content_details.contents_idContent = contents.idContent
		AND content_tosection.contents_idContent = contents.idContent
		AND content_tosection.sections_idSection = $idSection";
		$sql.=" AND content_details.idiomas_idIdioma=". self::$idIdioma ;
		$sql.=" AND content_details.activo=1";

		$sql.=" ORDER BY content_tosection.content_order ASC, contents.idContent ASC";
		
		///echo $sql;die;

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

		addContentFurl($contents,$path);

		return $contents;
	}

	public static function getContent($id,$idSection,$path){

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

		addContentFurl($content,$path);

		return $content;
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