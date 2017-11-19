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
interface IRecordset{
	/**
	 * @param string $sql
	 * @return void
	 */
	public function execute($sql);
	/**
	 * @return void
	 */
	public function moveNext();
	/**
	 * @param string $value
	 * @return string
	 */
	public function field($value);
	/**
	 * @return array
	 */
	public function rows();
	/**
	 * @return void
	 */
	public function close();
	/**
	 * @param string $value
	 * @return int
	 */
	public function getInt($value);
	/**
	 * @param string $value
	 * @return double
	 */
	public function getDouble($value);
	/**
	 * @param string $value
	 * @return Fecha
	 */
	public function getDate($value);
	/**
	 *
	 * @param string $sql
	 * @return string
	 */
	public function getJSON($sql);
	/**
	 *
	 * @param string $sql
	 * @return array <stdClass>
	 */
	public function getObjects($sql);
	/**
	 *
	 * @param string $sql
	 * @return stdClass
	 */
	public function getObject($sql);
}
?>