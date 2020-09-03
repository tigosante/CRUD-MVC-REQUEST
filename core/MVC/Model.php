<?php

namespace core\MVC;

use core\Connections\OracleConnection;
use core\Interfaces\Connections\DataBaseConnectionInterface;

class Model
{
  /**
   * @var DataBaseConnectionInterface $dataBaseObject
   */
  public $dataBaseObject;

  public function __construct(DataBaseConnectionInterface $dataBaseConnectionInterface = null)
  {
    $this->dataBaseObject = $dataBaseConnectionInterface ? $dataBaseConnectionInterface::singleton() : OracleConnection::singleton();
    $this->dataBaseObject->createConnection();
  }
}
