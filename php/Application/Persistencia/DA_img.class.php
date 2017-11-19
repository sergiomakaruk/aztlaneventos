<?php

/**
 * Date: 14/08/2013 14:28:41
 * @version 1.0
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2013, Hugo Vazquez
 * @filename DA.class.php
 * @package
 **/

/**
 */
class DA_img extends DA_Abs {

	public static function setFoto($data){
		
		if(!self::guardarImg(escape($data->img),escape($data->nombre),escape($data->path))){
			throw new AppException("Error setFoto:" . 'NO SE GUARDO LA FOTO: nombre- ' .escape($data->nombre).' - '.escape($data->path), 200);
		}		
		
		
		return true;
	}
	
	private static function guardarImg($foto,$nombre,$path) {
		echo '../../'.$path.$nombre;
		try
		{
			if ($fp = fopen('../../'.$path.$nombre,"wb")) {
				fwrite($fp,base64_decode($foto));
				fclose($fp);
				return true;			
			}
		}
	catch (Exception $e) {
			new AppException("guardarImg(): Error inesperado ($c):" . $e->getMessage(), 200);			
		}
		
		return false;
	}

}


?>
