<?php

namespace core\Interfaces\MVC;

use core\Interfaces\Connections\DataBaseConnectionInterface;

/**
 * @method __construct(DataBaseConnectionInterface $dataBaseConnectionInterface = null)
 */
interface ModelInterface
{
  public function __construct(DataBaseConnectionInterface $dataBaseConnectionInterface = null);
}
