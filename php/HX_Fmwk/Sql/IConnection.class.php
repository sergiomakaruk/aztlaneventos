<?php
/**
 * Date: 25/11/2008 09:41:54
 * @version 1.0
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2012, Hugo Vazquez
 * @package HX_Fmwk/Sql
 * @filesource
 **/

/**
 *
 **/
interface IConnection{
	/**
	 * @return IRecordset
	 */
	public function getRecordset();
	/**
	 * @param string $strCon
	 * @return void
	 */
	public function open($strCon);
	/**
	 * @param string $sql
	 * @return array
	 */
	public function execute($sql);
	/**
	 * @return void
	 */
	public function close();

	/**
	 * @return bool
	 */
	public function isClosed();

}
?>