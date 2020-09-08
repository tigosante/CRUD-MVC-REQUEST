<?php

namespace core\SimpleORM\QuerySql;

use core\interfaces\{
  QuerySql\QuerySqlInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

/**
 * @method select(array $tableColumns = null): self;
 * @method join(string $joinCondition): self;
 * @method where(array $whereCondition): self;
 * @method groupBy(array $groupByCondition): self;
 * @method orderBy(array $orderByCondition): self;
 * @method clean(): void;
 * @method fetchAll(): array;
 * @method getQueryString(): string;
 */
class QuerySql implements QuerySqlInterface
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
    $this->querySqlStringInterface->setWhere($whereCondition);
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
    $this->repositoryDataDBInterface->setQuery($this->getQueryString());
    $this->repositoryDataDBInterface->setData($this->getData());

    return $this->repositoryDataDBInterface->getDataDB();
  }

  public function getQueryString(): string
  {
    return
      $this->querySqlStringInterface->getSelect() .
      $this->querySqlStringInterface->getJoin() .
      $this->querySqlStringInterface->getWhere() .
      $this->querySqlStringInterface->getGroupBy() .
      $this->querySqlStringInterface->getOrderBy();
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
