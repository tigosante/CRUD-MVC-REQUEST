<?php

namespace core\Interfaces\QuerySql;

use core\interfaces\TableObject\TableInfoInterface;

/**
 * @method getSelect(): string;
 * @method setSelect(array $tableColumns = null): void;
 * @method getJoin(): string;
 * @method setJoin(string $joinCondition): void;
 * @method getWhere(): string;
 * @method setWhere(array $whereCondition): void;
 * @method getGroupBy(): string;
 * @method setGroupBy(array $groupByCondition): void;
 * @method getOrderBy(): string;
 * @method setOrderBy(array $orderByCondition): void;
 * @method getInsert(): string;
 * @method setInsert(array $tableColumns = null): void;
 * @method getUpdate(): string;
 * @method setUpdate(array $tableColumns = null): void;
 * @method getDelete(): string;
 * @method setDelete(int $identifier): void;
 * @method clean(): void;
 */
interface QuerySqlStringInterface
{
  public function __construct(TableInfoInterface $tableInfoInterface);

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

  public function clean(): void;
}
