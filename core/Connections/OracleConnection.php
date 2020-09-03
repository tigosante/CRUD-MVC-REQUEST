<?php

namespace core\Connections;

use core\Interfaces\Connections\DataBaseConnectionInterface;

class OracleConnection implements DataBaseConnectionInterface
{
  /**
   * @var self $singletonObject
   */
  public static $singletonObject;

  /**
   * @var \PDO $connection
   */
  public $connection;

  public $dsn = null;
  public $username = null;
  public $password = null;
  public $options = null;

  public static function singleton(): self
  {
    if (!(isset(self::$singletonObject))) {
      self::$singletonObject = new self;
    }

    return self::$singletonObject;
  }

  public  function createConnection(array $options = null): bool
  {
    $result = true;

    try {
      $this->connection = new \PDO($this->dsn, $this->username, $this->password, $options ?? $this->options);
    } catch (\PDOException $exception) {
      $result = false;
      var_dump("Erro ao criar conexão com o banco de dados: " . $exception->getMessage());
    }

    return $result;
  }

  public function getConnection(): \PDO
  {
    return $this->connection;
  }
}
