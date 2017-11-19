<?php

/**
 * Date: 14/08/2013 13:39:30
 * @version 1.0
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2013, Hugo Vazquez
 * @filename AppException.class.php
 * @package
 **/

/**
 */
class AppException extends Exception {

  /**
   *
   * @param string $msg
   * @param string $code
   */
  public function __construct($msg, $code) {
    parent::__construct(utf8_encode($msg), $code);
    //Logger::logError($this);
  }
}

?>