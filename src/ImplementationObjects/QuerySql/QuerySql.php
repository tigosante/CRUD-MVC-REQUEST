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
  private static $querySqlStringInterface;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDBInterface
   */
  private static $repositoryDataDBInterface;

  public static function config(QuerySqlStringInterface &$querySqlStringInterface, RepositoryDataDBInterface &$repositoryDataDBInterface): self
  {
    self::$querySqlStringInterface = $querySqlStringInterface;
    self::$repositoryDataDBInterface = $repositoryDataDBInterface;

    return new self;
  }

  public function select(array $tableColumns = null): self
  {
    self::$querySqlStringInterface->setSelect($tableColumns);
    return $this;
  }

  public function join(string $joinCondition): self
  {
    self::$querySqlStringInterface->setJoin($joinCondition);
    return $this;
  }

  public function where(array $whereCondition): self
  {
    foreach ($whereCondition as $value) {
      self::$querySqlStringInterface->setWhere($value);
    }

    return $this;
  }

  public function groupBy(array $groupByCondition): self
  {
    self::$querySqlStringInterface->setGroupBy($groupByCondition);
    return $this;
  }

  public function orderBy(array $orderByCondition): self
  {
    self::$querySqlStringInterface->setOrderBy($orderByCondition);
    return $this;
  }

  public function clean(): void
  {
    self::$querySqlStringInterface->clean();
  }

  public function fetchAll(): array
  {
    self::$repositoryDataDBInterface->setQuery($this->queryString());
    return self::$repositoryDataDBInterface->recoverData();
  }

  public function getData(): array
  {
    return self::$repositoryDataDBInterface->getData();
  }

  public function setData(array $data): void
  {
    self::$repositoryDataDBInterface->setData($data);
  }

  public function queryString(): string
  {
    return
      self::$querySqlStringInterface->getSelect() .
      self::$querySqlStringInterface->getJoin() .
      self::$querySqlStringInterface->getWhere() .
      self::$querySqlStringInterface->getGroupBy() .
      self::$querySqlStringInterface->getOrderBy();
  }
}
