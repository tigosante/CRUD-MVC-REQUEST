<?php

namespace core\MVC;

use core\Connections\OracleConnection;
use core\Interfaces\MVC\ModelInterface;
use core\Interfaces\Connections\DataBaseConnectionInterface;

class Model implements ModelInterface
{
  /**
   * @var DataBaseConnectionInterface $dataBaseObject
   */
  public $dataBaseObject;

  public function __construct(DataBaseConnectionInterface $dataBaseConnectionInterface = null, array $options = null)
  {
    $this->dataBaseObject = $dataBaseConnectionInterface ? $dataBaseConnectionInterface : OracleConnection::singleton();
    $this->dataBaseObject->createConnection($options);
  }
}
