<?php

namespace src\MVC;

use src\Connections\OracleConnection;
use src\Interfaces\{
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
