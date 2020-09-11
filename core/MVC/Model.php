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
   * @var \PDO $connection
   */
  public $connection;

  public function __construct(DataBaseConnectionInterface $dataBaseConnectionInterface = null)
  {
    $this->connection = $dataBaseConnectionInterface->getConnection() ? $dataBaseConnectionInterface : OracleConnection::singleton()->getConnection();
  }
}
