<?php

namespace src\ImplementationObjects\QuerySql;

use src\interfaces\{
  QuerySql\QuerySqlInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

class QuerySql implements QuerySqlInterface
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

  public function select(array $tableColumns = null): self
  {
    $this->querySqlStringInterface->setSelect($tableColumns);
    return $this;
  }

  public function join(string $joinCondition): self
  {
    $this->querySqlStringInterface->setJoin($joinCondition);
    return $this;
  }

  public function where(array $whereCondition): self
  {
    foreach ($whereCondition as $value) {
      $this->querySqlStringInterface->setWhere($value);
    }

    return $this;
  }

  public function groupBy(array $groupByCondition): self
  {
    $this->querySqlStringInterface->setGroupBy($groupByCondition);
    return $this;
  }

  public function orderBy(array $orderByCondition): self
  {
    $this->querySqlStringInterface->setOrderBy($orderByCondition);
    return $this;
  }

  public function clean(): void
  {
    $this->querySqlStringInterface->clean();
  }

  public function fetchAll(): array
  {
    $this->repositoryDataDBInterface->setQuery($this->queryString());
    return $this->repositoryDataDBInterface->recoverData();
  }

  public function getData(): array
  {
    return $this->repositoryDataDBInterface->getData();
  }

  public function setData(array $data): void
  {
    $this->repositoryDataDBInterface->setData($data);
  }

  public function queryString(): string
  {
    return
      $this->querySqlStringInterface->getSelect() .
      $this->querySqlStringInterface->getJoin() .
      $this->querySqlStringInterface->getWhere() .
      $this->querySqlStringInterface->getGroupBy() .
      $this->querySqlStringInterface->getOrderBy();
  }
}
