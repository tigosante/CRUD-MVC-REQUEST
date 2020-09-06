<?php

namespace core\MVC;

use core\Connections\OracleConnection;
use core\Interfaces\{
  MVC\ModelInterface,
  Connections\DataBaseConnectionInterface
};

class Model implements ModelInterface
{
  /**
   * @var DataBaseConnectionInterface $dataBaseObject
   */
  public $dataBaseObject;

  public function __construct(DataBaseConnectionInterface $dataBaseConnectionInterface = null)
  {
    $this->dataBaseObject = $dataBaseConnectionInterface ? $dataBaseConnectionInterface : OracleConnection::singleton();
  }
}
