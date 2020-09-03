<?php

namespace core\SimpleORM\SQLCommands;

use core\interfaces\Repository\RepositoryGetDataInterface;
use core\interfaces\SQLCommands\{SQLCommandsInterface, SQLCommandsHelperInterface};

class SQLCommands implements SQLCommandsInterface
{
  /**
   * @var SQLCommandsHelperInterface $sql
   */
  private $sql;

  /**
   * @var RepositoryGetDataInterface $repositoryGetDataInterface
   */
  private $repositoryGetDataInterface;

  public function __construct(SQLCommandsHelperInterface $sqlCommandsHelperInterface, RepositoryGetDataInterface $repositoryGetDataInterface)
  {
    $this->sql = $sqlCommandsHelperInterface;
    $this->repositoryGetDataInterface = $repositoryGetDataInterface;
  }

  public function select(array $tableColumns = null): self
  {
    $this->sql->setSelect($tableColumns);
    return $this;
  }

  public function join(string $joinCondition): self
  {
    $this->sql->setJoin($joinCondition);
    return $this;
  }

  public function where(array $whereConditions): self
  {
    $this->sql->setWhere($whereConditions);
    return $this;
  }

  public function groupBy(array $groupByCondition): self
  {
    $this->sql->setGroupBy($groupByCondition);
    return $this;
  }

  public function orderBy(array $orderByCondition): self
  {
    $this->sql->setOrderBy($orderByCondition);
    return $this;
  }

  public function clean(): void
  {
    $this->sql->clean();
  }

  public function setdata(array $data = null): self
  {
    $this->repositoryGetDataInterface->setData($data);
    return $this;
  }

  public function getQueryString(): string
  {
    return
      $this->sql->getSelect() .
      $this->sql->getJoin() .
      $this->sql->getWhere() .
      $this->sql->getGroupBy() .
      $this->sql->getOrderBy();
  }

  public function fetchAll(): array
  {
    $this->repositoryGetDataInterface->setQuery($this->getQueryString());
    return $this->repositoryGetDataInterface->getDataFromDB();
  }
}
