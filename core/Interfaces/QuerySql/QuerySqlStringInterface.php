<?php

namespace core\Interfaces\QuerySql;

use core\interfaces\TableObject\TableInfoInterface;

interface QuerySqlStringInterface
{
  public function __construct(TableInfoInterface &$tableInfoInterface);

  public function getSelect(): string;
  public function setSelect(array $tableColumns = null): void;

  public function getJoin(): string;
  public function setJoin(string $joinCondition): void;

  public function getWhere(): string;
  public function setWhere(string $whereCondition, int $tableIdentifier = null): void;

  public function getGroupBy(): string;
  public function setGroupBy(array $groupByCondition): void;

  public function getOrderBy(): string;
  public function setOrderBy(array $orderByCondition): void;

  public function getInsert(): string;
  public function setInsert(array $tableColumns = null): void;

  public function getUpdate(): string;
  public function setUpdate(array $tableColumns = null): void;

  public function getDelete(): string;
  public function setDelete(int $tableIdentifier): void;

  public function getTableIdentifier(): string;
  public function setTableIdentifier(int $tableIdentifier): void;

  public function clean(): void;
}
