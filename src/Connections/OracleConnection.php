<?php

namespace src\Connections;

use src\Interfaces\Connections\DataBaseConnectionInterface;

class OracleConnection implements DataBaseConnectionInterface
{
  /**
   * @var self $singletonObject
   */
  private static $singletonObject;

  /**
   * @var \PDO $connection
   */
  private $connection;

  private $dsn = "";
  private $username = "";
  private $password = "";
  private $options = [];

  public static function singleton(): self
  {
    if (!(isset(self::$singletonObject))) {
      self::$singletonObject = new self;
    }

    return self::$singletonObject;
  }

  private function createConnection(): bool
  {
    $result = true;

    try {
      $this->connection = new \PDO($this->dsn, $this->username, $this->password, $this->options);
    } catch (\PDOException $exception) {
      $result = false;
      var_dump("Erro ao criar conexão com o banco de dados: " . $exception->getMessage());
    }

    return $result;
  }

  public function getConnection(): \PDO
  {
    $this->createConnection();
    return $this->connection;
  }
}
