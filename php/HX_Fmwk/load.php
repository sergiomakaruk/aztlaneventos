<?php
/**
 * Date: 23/10/2008 19:56:32
 * @version 1.0
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2011, Hugo Vazquez
 * @package hx_fmwk
 *
 */
$__microtime__=microtime(true);
session_start();
ob_start();
define("rootPath",str_replace("\\", "/",dirname(dirname(__FILE__))."/"));
define("fmwkPath",rootPath."HX_Fmwk/");
define("appPath",rootPath."Application/");
define("libsPath",fmwkPath."libs/");

require_once fmwkPath."Functions/functions.php";

//manejador de excepciones
set_exception_handler('gestorExcepciones');

loadFrameworks();


?>