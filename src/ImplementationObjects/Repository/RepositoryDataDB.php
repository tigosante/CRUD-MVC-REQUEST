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

  public function __construct(DataBaseConnectionInterface &$dataBaseConnectionInterface)
  {
    if ($dataBaseConnectionInterface->createConnection()) {
      $this->connection = $dataBaseConnectionInterface->getConnection();
    }
  }

  private function verifyData(): void
  {
    $dataArray = $this->getData();

    if (!(empty($dataArray))) {
      $this->dataDB = $dataArray;
    }
  }

  public function recoverData(): array
  {
    $this->verifyData();
    $statement = $this->connection->prepare($this->getQuery());
    $statement->execute($this->dataDB);

    return $statement->fetchAll();
  }

  public function handleData(): bool
  {
    $this->verifyData();
    return $this->connection->prepare($this->getQuery())->execute($this->dataDB);
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
        $this->data[":{$key}"] = $value;
      }
    }
  }

  public function clean(): void
  {
    $this->data = [];
    $this->query = "";
    $this->dataDB = null;
  }
}
