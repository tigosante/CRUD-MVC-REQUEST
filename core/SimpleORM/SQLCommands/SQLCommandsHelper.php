<?php

namespace core\SimpleORM\SQLCommands;

use core\interfaces\{
  SQLCommands\SQLCommandsHelperInterface,
  TableObject\TableObjectHelperInterface
};

class SQLCommandsHelper implements SQLCommandsHelperInterface
{
  /**
   * @var TableObjectHelperInterface $tableObjectHelperInterface
   */
  private $tableObjectHelperInterface;

  /**
   * @var string $dataBaseName
   */
  private $dataBaseName = null;

  /**
   * @var string $tableName
   */
  private $tableName = null;

  /**
   * @var array $tableColumns
   */
  private $tableColumns = null;

  /**
   * @var string $select
   */
  private $select = null;

  /**
   * @var array $joinCondition
   */
  private $joinCondition = [];

  /**
   * @var array $whereCondition
   */
  private $whereCondition = [];

  /**
   * @var array $groupByCondition
   */
  private $groupByCondition = [];

  /**
   * @var array $orderByCondition
   */
  private $orderByCondition = [];

  /**
   * @var string $typeOrderBy
   */
  private $typeOrderBy = null;

  public function __construct(TableObjectHelperInterface $tableObjectHelperInterface)
  {
    $this->tableObjectHelperInterface = $tableObjectHelperInterface;

    $this->dataBaseName = $tableObjectHelperInterface->getDataBaseName();
    $this->tableName = $tableObjectHelperInterface->getTableName();
    $this->tableColumns = $tableObjectHelperInterface->getTableColumns();
  }

  public function getSelect(): string
  {
    return $this->select;
  }

  public function setSelect(array $tableColumns = null): void
  {
    $columns = $tableColumns ? join(", ", $this->tableColumns) : "*";
    $this->select = "SELECT {$columns} FROM {$this->dataBaseName}{$this->tableName} ";
  }

  public function getJoin(): string
  {
    return join("\n    ", $this->joinConditio);
  }

  public function setJoin(string $joinCondition, string $typeJoin = "INNER"): void
  {
    array_push($this->joinCondition, "{$typeJoin} JOIN {$joinCondition}");
  }

  public function getWhere(): string
  {
    return " WHERE 1=1 " . join(" ", $this->whereCondition);
  }

  public function setWhere(array $whereCondition): void
  {
    $this->whereCondition = $whereCondition;
  }

  public function getGroupBy(): string
  {
    return " GROUP BY " . join(", ", $this->groupByCondition);
  }

  public function setGroupBy(array $groupByCondition): void
  {
    $this->groupByCondition = $groupByCondition;
  }

  public function getOrderBy(): string
  {
    return " ORDER BY " . join(", ", $this->orderByCondition) . " {$this->typeOrderBy} ";
  }

  public function setOrderBy(array $orderByCondition, string $typeOrderBy = "ASC"): void
  {
    $this->typeOrderBy = $typeOrderBy;
    $this->orderByCondition = $orderByCondition;
  }

  public function clean(): void
  {
    $this->joinCondition = [];
    $this->whereCondition = [];
    $this->groupByCondition = [];
    $this->orderByCondition = [];
    $this->typeOrderBy = "ASC";
  }
}
