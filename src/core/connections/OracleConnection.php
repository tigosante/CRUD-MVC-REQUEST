<?php

namespace src\connections;

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
  private \PDO $connection;

  private string $dsn = "";
  private string $username = "";
  private string $password = "";
  private array $options = array();

  public static function singleton(): self
  {
    if (!(isset(self::$instance))) {
      self::$instance = new self;
    }

    return self::$instance;
  }

  protected function __construct()
  {
  }

  protected function __wakeup()
  {
  }

  protected function __clone()
  {
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
