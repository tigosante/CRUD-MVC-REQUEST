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

  public function __construct(DataBaseConnectionInterface &$dataBaseConnectionInterface)
  {
    $this->connection = $dataBaseConnectionInterface->getConnection();
  }

  public function getDataDB(): ?array
  {
    $statement = $this->connection->prepare($this->getQuery());
    $statement->execute($this->getData());

    return $statement->fetchAll();
  }

  public function handleDataDB(): bool
  {
    return $this->connection->prepare($this->getQuery())->execute($this->getData());
  }

  public function getQuery(): ?string
  {
    return $this->query ?? "";
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
    $this->query = $data;
  }
}
