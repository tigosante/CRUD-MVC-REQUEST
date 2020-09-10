<?php

namespace core\SimpleORM\Repository;

use core\Interfaces\{
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
  private $query = null;

  /**
   * @var array $data
   */
  private $data = null;

  /**
   * @var array $dataDB
   */
  private $dataDB = null;

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

    return $statement->fetchAll();
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
    $this->data = $data;
  }

  public function clean(): void
  {
    $this->data = [];
    $this->query = "";
    $this->dataDB = null;
  }
}
