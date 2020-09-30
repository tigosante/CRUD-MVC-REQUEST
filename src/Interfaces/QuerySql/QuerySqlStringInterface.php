<?php

namespace src\Interfaces\QuerySql;

use src\interfaces\TableObject\TableInfoInterface;

interface QuerySqlStringInterface
{
  public function __construct(TableInfoInterface &$tableInfoInterface);

  public function getSelect(): string;
  public function setSelect(array $tableColumns = null): void;

  public function getJoin(): string;
  public function setJoin(string $joinCondition): void;

  public function getWhere(): string;
  public function setWhere(string $whereCondition): void;

  public function getGroupBy(): string;
  public function setGroupBy(array $groupByCondition): void;

  public function getOrderBy(): string;
  public function setOrderBy(array $orderByCondition, string $typeOrderBy = "ASC"): void;

  public function getInsert(): string;
  public function setInsert(array $tableColumns = null): void;

  public function getUpdate(): string;
  public function setUpdate(array $tableColumns = null): void;

  public function getDelete(): string;
  public function setDelete(): void;

  public function clean(): void;
}
