<?php

class SET_content extends DA_Abs{
	
	public static function setCustomHome($data){		
		$titulo = $data['titulo'];
		$subtitulo = $data['subtitulo'];
		$descuento = $data['descuento'];
		$tieneDescuento = 0;
		if(isset($data['tieneDescuento']))$tieneDescuento = ( $data['tieneDescuento'] == 'on') ? 1:0;
		$texto = escape(htmlspecialchars($data['texto']));

		$sql = "UPDATE customHome SET		
		titulo='$titulo',
		subtitulo='$subtitulo',
		descuento='$descuento',
		tieneDescuento='$tieneDescuento',
		texto='$texto' 
		WHERE id = 1";

		try
		{
			$db = Conexion::getConexion();
			$db->execute($sql);			

			return true;
		}
		catch (Exception $e) {
			$c = $e->getCode();
			throw new AppException("Error setCustomHome ($c):" . $e->getMessage(), 200);
		}		
	}
	
	public static function setCustomPopup($data){
		//var_dump($data);
		$activo = 0;
		if(isset($data['activo']))$activo = ( $data['activo'] == 'on') ? 1:0;	
		$bordercolor = $data['bordercolor'];		
		$delay = $data['delay'];
		$titulo = $data['titulo'];	
		$fontsize = $data['fontsize'];	
		$texto = escape(htmlspecialchars($data['texto']));
		$textoboton = $data['textoboton'];	
		$link = $data['link'];	
		$isblank = 0;
		if(isset($data['isblank']))$isblank = ( $data['isblank'] == 'on') ? 1:0;
		$mostrarfooter = 0;
		if(isset($data['mostrarfooter']))$mostrarfooter = ( $data['mostrarfooter'] == 'on') ? 1:0;
		
		$sql = "UPDATE customPopup SET
		activo='$activo',
		bordercolor='$bordercolor',
		delay='$delay',
		titulo='$titulo',
		fontsize='$fontsize',
		texto='$texto',
		textoboton='$textoboton',
		link='$link',
		isblank='$isblank',
		mostrarfooter='$mostrarfooter'		
		WHERE id = 1";

		try
		{
			$db = Conexion::getConexion();
			$db->execute($sql);			

			return true;
		}
		catch (Exception $e) {
			$c = $e->getCode();
			throw new AppException("Error setCustomPopup ($c):" . $e->getMessage(), 200);
		}		
	}

	public static function createContent($data){

		$active = $data->details->active;
		$title = $data->details->title;
		$desc = $data->details->description;
		$SEO_desc = $data->details->SEO_desc;
		$order = $data->order;
		$idSection = $data->idSection;
		$align = $data->align;
		$pathImg = $data->pathImg;
		$rname = $data->rname;
		$fecha = new Fecha();


		$sqlAbs = "INSERT INTO contents (fecha,
		contentTypes_idType,
		img,
		imgAlign,
		referenceName)
		VALUES (
		'$fecha',2,'$pathImg',$align,'$rname')";

		try
		{
			$db = Conexion::getConexion();

			$db->execute($sqlAbs);
			//echo $sqlAbs;die;

			$nid = self::lastId($db);

			//creando...si tiene imagen...formateo el nombre sumando el id y lo guardo. El pathImg queda para guardar la imagen luego de la consulta...cuando ya tengo el id
			if(!is_null($data->img)){
				$data->pathImg =  $rname ."_". $nid . ".jpg";
				$pathImg = $data->pathImg;
				$sqlAbs = "UPDATE contents 	SET img = '$pathImg' WHERE idContent=$nid";
				//echo $sqlAbs;die;
				$db->execute($sqlAbs);
			}

			$sqlDetails = "INSERT INTO `content_details`
			(`idiomas_idIdioma`,
			`contents_idContent`,
			`titulo`,
			`descripcion`,
			`SEO_desc`,		
			`activo`)
			VALUES (".
			self::$idIdioma . ",
			$nid,
			'$title',
			'$desc',
			'$SEO_desc',
			$active )";

			//echo $sqlDetails;die;

			$db->execute($sqlDetails);


			$sqlRelations = "INSERT INTO content_tosection (contents_idContent,sections_idSection,content_order) VALUES (
			$nid,$idSection,$order )";

			//echo $sqlRelations;die;

			$db->execute($sqlRelations);

			$parent = GET_section::getParent($idSection);
			if($parent){
				$sqlRelations = "INSERT INTO content_tosection (contents_idContent,sections_idSection,content_order) VALUES (
				$nid,$parent->id,$order)";

				$db->execute($sqlRelations);
			}

			return GET_content::getContent($nid,$idSection);
		}
		catch (Exception $e) {
			$c = $e->getCode();
			throw new AppException("Error inesperado ($c):" . $e->getMessage(), 200);
		}
	}

	public static function updateContent($data){

		$cid = $data->id;
		$active = $data->details->active;
		$title = $data->details->title;
		$desc = $data->details->description;
		$SEO_desc = $data->details->SEO_desc;
		$order = $data->order;
		$idSection = $data->idSection;
		$align = $data->align;
		$pathImg = $data->pathImg;
		//$fecha = new Fecha();

		$sqlAbs = "UPDATE contents SET
		imgAlign = $align,img = '$pathImg' WHERE idContent = $cid";

		if(!is_null($pathImg)){
			$sqlAbs = "UPDATE contents SET
			imgAlign = $align,img = '$pathImg' WHERE idContent = $cid";
		}else
		{
			$sqlAbs = "UPDATE contents SET
			imgAlign = $align WHERE idContent = $cid";
		}



		//if getDetails update else create
		$details = GET_content::getDetails($cid);

		//echo $sqlAbs;die;

		if(is_null($details)){

			$sqlDetails = "INSERT INTO `content_details`
			(`idiomas_idIdioma`,
			`contents_idContent`,
			`titulo`,
			`descripcion`,
			`SEO_desc`,
			`activo`)
			VALUES (".
						self::$idIdioma . ",
						$cid,
						'$title',
						'$desc',
						'$SEO_desc',
						$active )";
		}
		else{
			$sqlDetails = "UPDATE `content_details`
			SET `activo` = $active,
			`titulo` = '$title',
			`descripcion` = '$desc',
			`SEO_desc` = '$SEO_desc'
			WHERE `idiomas_idIdioma`=" . self::$idIdioma . "
			AND `contents_idContent` = $cid";
		}


		//solo se modifica si es castellano

		$sqlRelations = "UPDATE content_tosection
		SET content_order = $order
		WHERE contents_idContent = $cid AND sections_idSection = $idSection";

		try
		{
			$db = Conexion::getConexion();

			/*echo $sqlAbs;
			echo ';<br>';
			echo $sqlDetails;
			echo ';<br>';
			die;*/
			$db->execute($sqlAbs);
			$db->execute($sqlDetails);

			//solo se modifica si es castellano
			if(self::$idIdioma == 1)$db->execute($sqlRelations);

			return GET_content::getContent($cid,$idSection);
		}
		catch (Exception $e) {
			$c = $e->getCode();
			throw new AppException("Error inesperado ($c):" . $e->getMessage(), 200);
		}
	}


	public static function delete($cid){

		//contenidos to seccion
		//contentDetails
		//content
		$sql_1 = "DELETE FROM content_tosection WHERE contents_idContent=$cid";
		$sql_2 = "DELETE FROM content_details WHERE contents_idContent=$cid";
		$sql_3 = "DELETE FROM contents WHERE idContent=$cid";

		try
		{
			$db = Conexion::getConexion();
			//echo $sqlDetails;die;
			if(self::$idIdioma == 1)//solo borramos si es castewllano
			{
				$db->execute($sql_1);
				$db->execute($sql_2);
				$db->execute($sql_3);

				return true;
			}

			return false;
		}
		catch (Exception $e) {
			$c = $e->getCode();
			throw new AppException("Error inesperado ($c):" . $e->getMessage(), 200);
		}

	}

// 	public static function changeOrder($secciones){
// 		//var_dump($secciones);die;
// 		$sql ="UPDATE sections SET sectionOrder= ";
// 		foreach($secciones as $sec){
// 			$csql = $sql.$sec->order . " WHERE idSection=" . $sec->idSection;
// 			//echo $csql;die;
// 			try
// 			{
// 				$db = Conexion::getConexion();
// 				$db->execute($csql);
// 			}
// 			catch (Exception $e) {
// 				$c = $e->getCode();
// 				throw new AppException("Error inesperado ($c):" . $e->getMessage(), 200);
// 			}

// 		}
// 	}

}

?>