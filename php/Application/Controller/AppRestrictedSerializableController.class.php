<?php

/**
 * Date: 14/08/2013 15:28:01
 * @version 1.0
 * @author Hugo Vazquez <hugo.r.vazquez@gmail.com>
 * @copyright Copyright (c) 2013, Hugo Vazquez
 * @filename AppRestrictedSerializableController.class.php
 * @package
 **/

/**
 */
abstract class AppRestrictedSerializableController extends AppSerializableController {

  public function __construct() {
    parent::__construct();

    if (is_null($this->usuario)) {
      throw new AppException("El usuario no esta registrado!", 102);
    }

  }
}

?>