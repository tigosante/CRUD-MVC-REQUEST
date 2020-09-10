<?php

namespace core\SimpleORM\DataDB;

use core\Interfaces\{
  DataDB\DataDBInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

class DataDB implements DataDBInterface
{
  /**
   * @var QuerySqlStringInterface $querySqlStringInterface
   */
  private $querySqlStringInterface;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDBInterface
   */
  private $repositoryDataDBInterface;

  public function __construct(QuerySqlStringInterface &$querySqlStringInterface, RepositoryDataDBInterface &$repositoryDataDBInterface)
  {
    $this->querySqlStringInterface = $querySqlStringInterface;
    $this->repositoryDataDBInterface = $repositoryDataDBInterface;
  }

  public function findAll(array $tableColumns = null): array
  {
    $this->querySqlStringInterface->setSelect($tableColumns);
    $this->repositoryDataDBInterface->setQuery($this->querySqlStringInterface->getSelect());

    return $this->repositoryDataDBInterface->getDataDB();
  }

  public function delete(int $tableIdentifier): bool
  {
    $this->querySqlStringInterface->setDelete($tableIdentifier);
    $this->repositoryDataDBInterface->setQuery($this->querySqlStringInterface->getDelete());

    return $this->repositoryDataDBInterface->handleDataDB();
  }

  public function update(array $tableColumns = null): bool
  {
    $this->querySqlStringInterface->setUpdate($tableColumns);
    $this->repositoryDataDBInterface->setQuery($this->querySqlStringInterface->getUpdate());

    return $this->repositoryDataDBInterface->handleDataDB();
  }

  public function where(string $conditions): self
  {
    $this->querySqlStringInterface->setWhere($conditions);
    return $this;
  }

  public function getData(): ?array
  {
    return $this->repositoryDataDBInterface->getData();
  }

  public function setData(array $data): void
  {
    $this->repositoryDataDBInterface->setData($data);
  }
}
