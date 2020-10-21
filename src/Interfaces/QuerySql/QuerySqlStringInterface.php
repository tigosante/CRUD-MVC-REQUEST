<?php

namespace src\Interfaces\QuerySql;

use src\interfaces\TableObject\TableInfoInterface;

interface QuerySqlStringInterface
{
  /**
   * @return self
   */
  public static function config(TableInfoInterface &$tableInfoInterface): self;

  /**
   * @return string
   */
  public function getSelect(): string;

  /**
   * @return void
   */
  public function setSelect(array $tableColumns = null): void;

  /**
   * @return string
   */
  public function getJoin(): string;

  /**
   * @return void
   */
  public function setJoin(string $joinCondition): void;

  /**
   * @return string
   */
  public function getWhere(): string;

  /**
   * @return void
   */
  public function setWhere(string $whereCondition): void;

  /**
   * @return string
   */
  public function getGroupBy(): string;

  /**
   * @return void
   */
  public function setGroupBy(array $groupByCondition): void;

  /**
   * @return string
   */
  public function getOrderBy(): string;

  /**
   * @return void
   */
  public function setOrderBy(array $orderByCondition, string $typeOrderBy = "ASC"): void;

  /**
   * @return string
   */
  public function getInsert(): string;

  /**
   * @return void
   */
  public function setInsert(array $tableColumns = null): void;

  /**
   * @return string
   */
  public function getUpdate(): string;

  /**
   * @return void
   */
  public function setUpdate(array $tableColumns = null): void;

  /**
   * @return string
   */
  public function getDelete(): string;

  /**
   * @return void
   */
  public function setDelete(): void;

  /**
   * @return void
   */
  public function clean(): void;

  /**
   * @return array
   */
  public function getTableColumnsData(): array;

  /**
   * @return void
   */
  public function setTableColumnsData(array $tableColumnsData): void;
}
