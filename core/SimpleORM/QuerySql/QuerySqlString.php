<?php

namespace core\SimpleORM\QuerySql;

use core\Interfaces\{
  QuerySql\QuerySqlStringInterface,
  TableObject\TableInfoInterface
};

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
class QuerySqlString implements QuerySqlStringInterface
{
  /**
   * @var int $tableIdentifier
   */
  private $tableIdentifier = null;

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

  /**
   * @var string $insert
   */
  private $insert = null;

  /**
   * @var string $update
   */
  private $update = null;

  /**
   * @var string $delete
   */
  private $delete = null;

  /**
   * @var TableInfoInterface $tableInfoInterface
   */
  private $tableInfoInterface;

  public function __construct(TableInfoInterface $tableInfoInterface)
  {
    $this->tableInfoInterface = $tableInfoInterface;
  }

  public function getSelect(): string
  {
    return $this->select;
  }

  public function setSelect(array $tableColumns = null): void
  {
    $columns = empty($tableColumns) ?   " * " : join(", ", $tableColumns);
    $this->select = "SELECT {$columns} FROM " . $this->tableInfoInterface->getDataBaseName() . $this->tableInfoInterface->getTableName();
  }

  public function getJoin(): string
  {
    return join("\n    ", $this->joinCondition);
  }

  public function setJoin(string $joinCondition, string $typeJoin = "INNER"): void
  {
    array_push($this->joinCondition, "{$typeJoin} JOIN {$joinCondition}");
  }

  public function getWhere(): string
  {
    $identifier = empty($this->tableIdentifier) ? "" : $this->getTableIdentifier();
    return " WHERE 1=1 " . join(" ", $this->whereCondition) . " {$identifier} ";
  }

  public function setWhere(string $whereCondition, int $tableIdentifier = null): void
  {
    if ($tableIdentifier !== null) {
      $this->setTableIdentifier($tableIdentifier);
    }

    array_push($this->whereCondition, $whereCondition);
  }

  public function getTableIdentifier(): string
  {
    $identifierValue = "";

    if (!(isset($this->tableIdentifier))) {
      $identifierValue = $this->tableInfoInterface->getTableIdentifier() . " = {$this->tableIdentifier} ";
    }

    return $identifierValue;
  }

  public function setTableIdentifier(int $tableIdentifier): void
  {
    $this->tableIdentifier = $tableIdentifier;
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

  public function getInsert(): string
  {
    return $this->insert ?? "";
  }

  public function setInsert(array $tableColumns = null): void
  {
    $columns = $this->getColumnsFromArray(", ", $tableColumns);
    $columnsBinds = $this->getColumnsFromArray(", :", $tableColumns);

    $this->insert = "INSERT INTO " . $this->tableInfoInterface->getDataBaseName() . $this->tableInfoInterface->getTableName() . " ({$columns}) VALUES ({$columnsBinds}) ";
  }

  public function getUpdate(): string
  {
    return $this->update ?? "";
  }

  public function setUpdate(array $tableColumns = null): void
  {
    $columns = $this->getColumnsToUpdate($tableColumns);

    $this->update = "UPDATE " . $this->tableInfoInterface->getDataBaseName() . $this->tableInfoInterface->getTableName() . " SET {$columns} ";
  }

  public function getDelete(): string
  {
    return $this->delete ?? "";
  }

  public function setDelete(int $tableIdentifier): void
  {
    $this->delete = "DELETE {$this->dataBaseName}{$this->tableName} ";
  }

  public function clean(): void
  {
    unset($this->tableIdentifier);

    $this->tableColumns = [];
    $this->joinCondition = [];
    $this->whereCondition = [];
    $this->groupByCondition = [];
    $this->orderByCondition = [];

    $this->select = "";
    $this->insert = "";
    $this->update = "";
    $this->delete = "";
    $this->typeOrderBy = "ASC";
  }

  private function getColumnsFromArray(string $separator, array $tableColumns = null): string
  {
    $tableColumns = empty($tableColumns) ? $this->tableColumn : $tableColumns;

    return join($separator, $tableColumns);
  }

  private function getColumnsToUpdate(array $tableColumns = null): string
  {
    $columnsUpdate = "";
    $tableColumns = empty($tableColumns) ? $this->tableColumn : $tableColumns;

    foreach ($tableColumns as $column) {
      $columnsUpdate .= "{$column} = :{$column}";
    }

    return $columnsUpdate;
  }
}
