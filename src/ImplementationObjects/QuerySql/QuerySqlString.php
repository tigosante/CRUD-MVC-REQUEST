<?php

namespace src\ImplementationObjects\QuerySql;

use src\Interfaces\{
  TableObject\TableInfoInterface,
  QuerySql\QuerySqlStringInterface
};

class QuerySqlString implements QuerySqlStringInterface
{
  private const BREAK_LINE = "\n";
  private const SPACE_SEPARATOR = " ";

  /**
   * @var string $select
   */
  private $select = "";

  /**
   * @var array $joinCondition
   */
  private $joinCondition = array();

  /**
   * @var array $whereCondition
   */
  private $whereCondition = array();

  /**
   * @var array $groupByCondition
   */
  private $groupByCondition = array();

  /**
   * @var array $orderByCondition
   */
  private $orderByCondition = array();

  /**
   * @var string $typeOrderBy
   */
  private $typeOrderBy = "";

  /**
   * @var string $insert
   */
  private $insert = "";

  /**
   * @var string $update
   */
  private $update = "";

  /**
   * @var string $delete
   */
  private $delete = "";

  /**
   * @var array $tableColumnsData
   */
  private $tableColumnsData = array();

  /**
   * @var TableInfoInterface $tableInfoInterface
   */
  private static $tableInfoInterface;

  public static function config(TableInfoInterface &$tableInfoInterface): self
  {
    self::$tableInfoInterface = $tableInfoInterface;
    return new self;
  }

  public function getSelect(): string
  {
    return $this->select;
  }

  public function setSelect(array $tableColumns = null): void
  {
    $columns = empty($tableColumns) ?   " * " : strtoupper(join(", ", $tableColumns));
    $this->select = "SELECT {$columns} FROM " . self::$tableInfoInterface->getDataBaseName() . self::$tableInfoInterface->getTableName() . self::SPACE_SEPARATOR;
  }

  public function getJoin(): string
  {
    return strtoupper(join("\n    ", $this->joinCondition));
  }

  public function setJoin(string $joinCondition, string $typeJoin = "INNER"): void
  {
    array_push($this->joinCondition, " {$typeJoin} JOIN {$joinCondition} ");
  }

  public function getWhere(): string
  {
    $whereCommand = self::SPACE_SEPARATOR;

    if (empty($this->whereCondition)) {
      $whereCommand = " WHERE " . strtoupper(join(" ", $this->whereCondition)) . self::BREAK_LINE;
    }

    return $whereCommand;
  }

  public function setWhere(string $whereCondition): void
  {
    array_push($this->whereCondition, $whereCondition);
  }

  public function getGroupBy(): string
  {
    return " GROUP BY " . strtoupper(join(", ", $this->groupByCondition)) . self::BREAK_LINE;
  }

  public function setGroupBy(array $groupByCondition): void
  {
    $this->groupByCondition = $groupByCondition;
  }

  public function getOrderBy(): string
  {
    return " ORDER BY " . strtoupper(join(", ", $this->orderByCondition)) . " {$this->typeOrderBy} ";
  }

  public function setOrderBy(array $orderByCondition, string $typeOrderBy = "ASC"): void
  {
    $this->typeOrderBy = $typeOrderBy;
    $this->orderByCondition = $orderByCondition;
  }

  public function getInsert(): string
  {
    return $this->insert;
  }

  public function setInsert(array $tableColumns = null): void
  {
    $columns = $this->getColumnsFromArray(", ", $tableColumns);
    $columnsBinds = $this->getColumnsFromArray(", :", $tableColumns);

    $this->insert = "INSERT INTO " . self::$tableInfoInterface->getDataBaseName() . self::$tableInfoInterface->getTableName() . " ({$columns}) VALUES ({$columnsBinds}) ";
  }

  public function getUpdate(): string
  {
    return $this->update;
  }

  public function setUpdate(array $tableColumns = null): void
  {
    $columns = $this->getColumnsToUpdate($tableColumns);

    $this->update = "UPDATE " . self::$tableInfoInterface->getDataBaseName() . self::$tableInfoInterface->getTableName() . " SET {$columns} ";
  }

  public function getDelete(): string
  {
    return $this->delete;
  }

  public function setDelete(): void
  {
    $this->delete = "DELETE " . self::$tableInfoInterface->getDataBaseName() . self::$tableInfoInterface->getTableName() . self::SPACE_SEPARATOR;
  }

  public function clean(): void
  {
    $this->tableColumns = array();
    $this->joinCondition = array();
    $this->whereCondition = array();
    $this->groupByCondition = array();
    $this->orderByCondition = array();

    $this->select = "";
    $this->insert = "";
    $this->update = "";
    $this->delete = "";
    $this->typeOrderBy = "ASC";
  }

  /**
   * @return array
   */
  public function getTableColumnsData(): array
  {
    return $this->tableColumnsData;
  }

  /**
   * @return void
   */
  public function setTableColumnsData(array $tableColumnsData): void
  {
    $this->tableColumnsData = $tableColumnsData;
  }

  private function getColumnsFromArray(string $separator, array $tableColumns = null): string
  {
    $tableColumns = empty($tableColumns) ? self::$tableInfoInterface->getTableColumns() : $tableColumns;
    $this->setTableColumnsData($tableColumns);

    return strtoupper(join($separator, $tableColumns));
  }

  private function getColumnsToUpdate(array $tableColumns = null): string
  {
    $columnsUpdate = array();
    $tableColumns = empty($tableColumns) ? self::$tableInfoInterface->getTableColumns() : $tableColumns;
    $this->setTableColumnsData($tableColumns);

    foreach ($tableColumns as $column) {
      array_push($columnsUpdate, " {$column} = :{$column} ");
    }

    return strtoupper(join(", ", $columnsUpdate));
  }
}
