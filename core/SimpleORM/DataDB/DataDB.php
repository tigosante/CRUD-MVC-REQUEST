<?php

namespace core\SimpleORM\DataDB;

use core\Interfaces\{
  DataDB\DataDBInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

/**
 * @method __construct(QuerySqlStringInterface $querySqlStringInterface, RepositoryDataDBInterface $repositoryDataDBInterface)
 * @method find(int $tableIdentifier, array $tableColumns = null): array
 * @method findAll(array $tableColumns = null): array
 * @method delete(int $tableIdentifier): bool
 * @method update(array $tableColumns = null): bool
 * @method where(string $conditions): self
 * @method getData(): ?array
 * @method setData(array $data): void
 */
class DataDB implements DataDBInterface
{
  /**
   * @var array $data
   */
  private $data;

  /**
   * @var QuerySqlStringInterface $querySqlStringInterface
   */
  private $querySqlStringInterface;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDBInterface
   */
  private $repositoryDataDBInterface;

  public function __construct(QuerySqlStringInterface $querySqlStringInterface, RepositoryDataDBInterface $repositoryDataDBInterface)
  {
    $this->querySqlStringInterface = $querySqlStringInterface;
    $this->repositoryDataDBInterface = $repositoryDataDBInterface;
  }

  public function find(int $tableIdentifier, array $tableColumns = null): array
  {
    $this->querySqlStringInterface->setSelect($tableColumns);
    $this->repositoryDataDBInterface->setQuery($this->querySqlStringInterface->getSelect());
    $this->repositoryDataDBInterface->setData($this->getData());

    return $this->repositoryDataDBInterface->getDataDB();
  }

  public function findAll(array $tableColumns = null): array
  {
    $this->querySqlStringInterface->setSelect($tableColumns);
    $this->repositoryDataDBInterface->setQuery($this->querySqlStringInterface->getSelect());
    $this->repositoryDataDBInterface->setData($this->getData());

    return $this->repositoryDataDBInterface->getDataDB();
  }

  public function delete(int $tableIdentifier): bool
  {
    $this->querySqlStringInterface->setDelete($tableIdentifier);
    $this->repositoryDataDBInterface->setQuery($this->querySqlStringInterface->getDelete());
    $this->repositoryDataDBInterface->setData($this->getData());

    return $this->repositoryDataDBInterface->handleDataDB();
  }

  public function update(array $tableColumns = null): bool
  {
    $this->querySqlStringInterface->setUpdate($tableColumns);
    $this->repositoryDataDBInterface->setQuery($this->querySqlStringInterface->getUpdate());
    $this->repositoryDataDBInterface->setData($this->getData());

    return $this->repositoryDataDBInterface->handleDataDB();
  }

  public function where(string $conditions): self
  {
    $this->querySqlStringInterface->setWhere($conditions);
    return $this;
  }

  public function getData(): ?array
  {
    return $this->data;
  }

  public function setData(array $data): void
  {
    $this->data = $data;
  }
}
