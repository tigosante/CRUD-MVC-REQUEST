<?php

namespace src\ImplementationObjects\Repository;

use src\Interfaces\{
  Repository\RepositoryDataDBInterface,
  Connections\DataBaseConnectionInterface
};

class RepositoryDataDB implements RepositoryDataDBInterface
{
  /**
   * @var \PDO $connection
   */
  private static $connection;

  /**
   * @var string $query
   */
  private $query = "";

  /**
   * @var array $data
   */
  private $data = array();

  /**
   * @var array $dataDB
   */
  private $dataDB = null;

  public static function config(DataBaseConnectionInterface &$dataBaseConnectionInterface): self
  {
    if ($dataBaseConnectionInterface->createConnection()) {
      self::$connection = $dataBaseConnectionInterface->getConnection();
    }

    return new self;
  }

  private function verifyData(): void
  {
    $dataArray = $this->getData();

    if (!(empty($dataArray))) {
      foreach ($dataArray as $key => $value) {
        $this->dataDB[":{$key}"] = $value;
      }
    }
  }

  public function recoverData(): array
  {
    $this->verifyData();
    $statement = self::$connection->prepare($this->getQuery());
    $statement->execute($this->dataDB);

    return $statement->fetchAll();
  }

  public function handleData(): bool
  {
    $this->verifyData();

    var_dump($this->getQuery(), $this->dataDB);

    return true;
    // self::$connection->prepare($this->getQuery())->execute($this->dataDB);
  }

  public function getQuery(): string
  {
    return $this->query;
  }

  public function setQuery(string $query): void
  {
    $this->query = $query;
  }

  public function getData(): array
  {
    return $this->data;
  }

  public function setData(array $data): void
  {
    if (!(empty($data))) {
      foreach ($data as $key => $value) {
        $this->data[$key] = $value;
      }
    }
  }

  public function clean(): void
  {
    $this->data = array();
    $this->query = "";
    $this->dataDB = null;
  }
}
