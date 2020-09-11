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
  private $connection;

  /**
   * @var string $query
   */
  private $query = "";

  /**
   * @var array $data
   */
  private $data = [];

  /**
   * @var array $dataDB
   */
  private $dataDB = null;

  /**
   * @var int $fetch_style
   */
  private $fetch_style = null;

  /**
   * @var int $fetch_argument
   */
  private $fetch_argument = null;

  /**
   * @var array $ctor_args
   */
  private $ctor_args;

  public function __construct(DataBaseConnectionInterface &$dataBaseConnectionInterface)
  {
    $this->connection = $dataBaseConnectionInterface->getConnection();
  }

  private function verifyData(): void
  {
    $dataArray = $this->getData();

    if (!(empty($dataArray))) {
      $this->dataDB = $dataArray;
    }
  }

  public function getDataDB(): ?array
  {
    $this->verifyData();
    $statement = $this->connection->prepare($this->getQuery());
    $statement->execute($this->dataDB);

    return $statement->fetchAll($this->fetch_style, $this->fetch_argument, $this->ctor_args);
  }

  public function handleDataDB(): bool
  {
    $this->verifyData();
    return $this->connection->prepare($this->getQuery())->execute($this->dataDB);
  }

  public function getQuery(): ?string
  {
    return $this->query;
  }

  public function setQuery(string $query): void
  {
    $this->query = $query;
  }

  public function getData(): ?array
  {
    return $this->data;
  }

  public function setData(array $data): void
  {
    if (!(empty($data))) {
      $newDataArray = array();

      foreach ($data as $key => $value) {
        array_push($newDataArray, [":{$key}" => $value]);
      }

      array_merge($this->data, $newDataArray);
    }
  }

  public function clean(): void
  {
    $this->data = [];
    $this->query = "";
    $this->dataDB = null;
    $this->fetch_style = null;
    $this->fetch_argument = null;
    $this->ctor_args = array();
  }

  public function fetchAllConfiguration(int $fetch_style = null, int $fetch_argument = null, array $ctor_args = array()): void
  {
    if (!(empty($fetch_style))) {
      $this->fetch_style = $fetch_style;
    }

    if (!(empty($fetch_argument))) {
      $this->fetch_argument = $fetch_argument;
    }

    if (!(empty($ctor_args))) {
      $this->ctor_args = $ctor_args;
    }
  }
}
