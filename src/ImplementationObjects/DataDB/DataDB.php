<?php

namespace src\ImplementationObjects\DataDB;

use src\Interfaces\{
  DataDB\DataDBInterface,
  TableObject\TableInfoInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

class DataDB implements DataDBInterface
{
  /**
   * @var TableInfoInterface $tableInfoInterface
   */
  private $tableInfoInterface;

  /**
   * @var QuerySqlStringInterface $querySqlStringInterface
   */
  private $querySqlStringInterface;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDBInterface
   */
  private $repositoryDataDBInterface;

  public function __construct(QuerySqlStringInterface &$querySqlStringInterface, TableInfoInterface &$tableInfoInterface, RepositoryDataDBInterface &$repositoryDataDBInterface)
  {
    $this->tableInfoInterface = $tableInfoInterface;
    $this->querySqlStringInterface = $querySqlStringInterface;
    $this->repositoryDataDBInterface = $repositoryDataDBInterface;
  }

  public function findAll(array $tableColumns = null): array
  {
    $this->querySqlStringInterface->setSelect($tableColumns);
    $this->repositoryDataDBInterface->setQuery($this->querySqlStringInterface->getSelect() . $this->querySqlStringInterface->getWhere());

    return $this->repositoryDataDBInterface->recoverData();
  }

  public function delete(int $tableIdentifier): bool
  {
    $tableIdentifierName = $this->tableInfoInterface->getTableIdentifier();

    $this->querySqlStringInterface->setDelete();
    $this->querySqlStringInterface->setWhere("{$tableIdentifierName} = :{$tableIdentifierName}");

    $this->repositoryDataDBInterface->setData([$tableIdentifierName => $tableIdentifier]);
    $this->repositoryDataDBInterface->setQuery($this->querySqlStringInterface->getDelete() . $this->querySqlStringInterface->getWhere());

    return $this->repositoryDataDBInterface->handleData();
  }

  public function update(array $tableColumns = null): bool
  {
    $this->querySqlStringInterface->setUpdate($tableColumns);
    $this->repositoryDataDBInterface->setQuery($this->querySqlStringInterface->getUpdate() . $this->querySqlStringInterface->getWhere());

    return $this->repositoryDataDBInterface->handleData();
  }

  public function where(string $conditions): self
  {
    $this->querySqlStringInterface->setWhere($conditions);
    return $this;
  }

  public function getData(): array
  {
    return $this->repositoryDataDBInterface->getData();
  }

  public function setData(array $data): void
  {
    $this->repositoryDataDBInterface->setData($data);
  }
}
