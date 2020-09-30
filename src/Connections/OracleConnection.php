<?php

namespace src\Connections;

use src\Interfaces\Connections\DataBaseConnectionInterface;

class OracleConnection implements DataBaseConnectionInterface
{
  /**
   * @var self $instance
   */
  private static $instance;

  /**
   * @var \PDO $connection
   */
  private $connection;

  private $dsn = "";
  private $username = "";
  private $password = "";
  private $options = array();

  public static function singleton(): self
  {
    if (!(isset(self::$instance))) {
      self::$instance = new self;
    }

    return self::$instance;
  }

  public function createConnection(): bool
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
    return $this->connection;
  }
}
