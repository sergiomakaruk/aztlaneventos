<?php
/**
 * Date: 08/11/2011 12:12:44
 * @version 1.0
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2011, Hugo Vazquez
 * @package default
 * @filesource
 */
interface IserializableController{
	function addToSend($obj);
	function send($msg="");
}
?>