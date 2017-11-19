<?php

class SET_section extends DA_Abs{


	public static function createSection($data){
		//var_dump($data);die;

		$active = $data->details->active;
		$toMain = $data->details->toMainMenu;
		$name = escape($data->details->name);
		$tomainname = escape($data->details->toMainName);
		$level = $data->level;
		$parent = $data->parent;
		$order = $data->order;
		$type = $data->type;
		$showContent = $data->showContent;
		$rname = escape($data->rname);
		$fecha = new Fecha();

		$sqlAbs = "INSERT INTO sections (fecha,
				contentTypes_idType,
				level,
				sectionOrder,
				referenceName,
				showContent)
				VALUES (
				'$fecha',$type,$level,$order,'$rname',$showContent)";

		try
		{
			$db = Conexion::getConexion();


			//echo $sqlAbs;die;
			$db->execute($sqlAbs);

			$nid = self::lastId($db);

			$sqlDetails = "INSERT INTO `section_details`
			(`idiomas_idIdioma`,
			`sections_idSection`,
			`name`,
			`toMainMenu`,
			`toMainName`,
			`active`)
			VALUES (".
			self::$idIdioma . ",
			$nid,
			'$name',
			$toMain,
			'$tomainname',
			$active )";

			//echo $sqlDetails;die;

			$db->execute($sqlDetails);


			if($level !=0){

				$sqlRelations = "INSERT INTO section_relations (subSection,parent) VALUES (
				$nid,$parent )";

				//echo $sqlRelations;die;

				$db->execute($sqlRelations);
			}


			return GET_section::getSection($nid);
		}
		catch (Exception $e) {
			$c = $e->getCode();
			throw new AppException("Error inesperado ($c):" . $e->getMessage(), 200);
		}
	}

	public static function updateSection($data){

		$idSection = $data->id;
		$active = $data->details->active;
		$toMain = $data->details->toMainMenu;
		$type = $data->type;
		$name = escape($data->details->name);
		$tomainname = escape($data->details->toMainName);
		$rname = escape($data->rname);
		$showContent = $data->showContent;
		$fecha = new Fecha();

		//var_dump($data);die;

		$sqlAbs = "UPDATE sections SET referenceName='$rname',fecha='$fecha',contentTypes_idType=$type,showContent=$showContent WHERE idSection=$idSection";

		$details = GET_section::getDetails($idSection);
	
		if(is_null($details)){

			$sqlDetails = "INSERT INTO `section_details`
			(`idiomas_idIdioma`,
			`sections_idSection`,
			`name`,
			`toMainMenu`,
			`toMainName`,
			`active`)
			VALUES (".
						self::$idIdioma . ",
						$idSection,
						'$name',
						$toMain,
						'$tomainname',
						$active )";
		}
		else{
			$sqlDetails = "UPDATE section_details SET
			name='$name',
			active=$active,
			toMainMenu=$toMain,
			toMainName='$tomainname'
			WHERE sections_idSection=$idSection
			AND idiomas_idIdioma=" . self::$idIdioma;
		}

		try
		{
			$db = Conexion::getConexion();			
			if(self::$idIdioma == 1) $db->execute($sqlAbs);//solo modificamos si es castewllano

			$db->execute($sqlDetails);

			return true;
		}
		catch (Exception $e) {
			$c = $e->getCode();
			throw new AppException("Error updateSection() ($c):" . $e->getMessage(), 200);
		}

	}

	public static function delete($id){

		$section = GET_section::getSection($id);

		foreach($section->sections as $sub)
		{
			self::delete($sub->id);
		}

		//contenidos to seccion
		//sectionrelations
		//sectionDetails
		//section
		$sql_1 = "DELETE FROM content_tosection WHERE sections_idSection=$id";
		$sql_2 = "DELETE FROM section_relations WHERE parent=$id";
		$sql_3 = "DELETE FROM section_relations WHERE subSection=$id";
		$sql_4 = "DELETE FROM section_details WHERE sections_idSection=$id";
		$sql_5 = "DELETE FROM sections WHERE idSection=$id";

		try
		{
			$db = Conexion::getConexion();
			//echo $sqlDetails;die;
			if(self::$idIdioma == 1)//solo borramos si es castewllano
			{
				$db->execute($sql_1);
				$db->execute($sql_2);
				$db->execute($sql_3);
				$db->execute($sql_4);
				$db->execute($sql_5);

				return true;
			}

			return false;
		}
		catch (Exception $e) {
			$c = $e->getCode();
			throw new AppException("Error delete() ($c):" . $e->getMessage(), 200);
		}

	}

	public static function changeOrder($secciones){
		//var_dump($secciones);die;
		$sql ="UPDATE sections SET sectionOrder= ";
		foreach($secciones as $sec){
			$csql = $sql.$sec->order . " WHERE idSection=" . $sec->idSection;
			//echo $csql;die;
			try
			{
				$db = Conexion::getConexion();
				$db->execute($csql);
			}
			catch (Exception $e) {
				$c = $e->getCode();
				throw new AppException("Error inesperado ($c):" . $e->getMessage(), 200);
			}

		}
	}

}

?>