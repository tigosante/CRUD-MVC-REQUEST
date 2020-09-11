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

  public function __construct(TableInfoInterface &$tableInfoInterface)
  {
    $this->tableInfoInterface = $tableInfoInterface;
  }

  public function getSelect(): ?string
  {
    return $this->select;
  }

  public function setSelect(array $tableColumns = null): void
  {
    $columns = empty($tableColumns) ?   " * " : strtoupper(join(", ", $tableColumns));
    $this->select = "SELECT {$columns} FROM " . $this->tableInfoInterface->getDataBaseName() . $this->tableInfoInterface->getTableName() . self::SPACE_SEPARATOR;
  }

  public function getJoin(): ?string
  {
    return strtoupper(join("\n    ", $this->joinCondition));
  }

  public function setJoin(string $joinCondition, string $typeJoin = "INNER"): void
  {
    array_push($this->joinCondition, " {$typeJoin} JOIN {$joinCondition} ");
  }

  public function getWhere(): string
  {
    $identifier = self::SPACE_SEPARATOR;
    $whereCommand = self::SPACE_SEPARATOR;

    if (empty($this->tableIdentifier)) {
      $identifier = $this->getTableIdentifier();
    }
    if (empty($this->whereCondition)) {
      $whereCommand = " WHERE 1=1 " . strtoupper(join(" ", $this->whereCondition)) . " {$identifier} " . self::BREAK_LINE;
    }

    return $whereCommand;
  }

  public function setWhere(string $whereCondition, int $tableIdentifier = null): void
  {
    if ($tableIdentifier !== null) {
      $this->setTableIdentifier($tableIdentifier);
    }

    array_push($this->whereCondition, $whereCondition);
  }

  public function getGroupBy(): ?string
  {
    return " GROUP BY " . strtoupper(join(", ", $this->groupByCondition)) . self::BREAK_LINE;
  }

  public function setGroupBy(array $groupByCondition): void
  {
    $this->groupByCondition = $groupByCondition;
  }

  public function getOrderBy(): ?string
  {
    return " ORDER BY " . strtoupper(join(", ", $this->orderByCondition)) . " {$this->typeOrderBy} ";
  }

  public function setOrderBy(array $orderByCondition, string $typeOrderBy = "ASC"): void
  {
    $this->typeOrderBy = $typeOrderBy;
    $this->orderByCondition = $orderByCondition;
  }

  public function getInsert(): ?string
  {
    return $this->insert;
  }

  public function setInsert(array $tableColumns = null): void
  {
    $columns = $this->getColumnsFromArray(", ", $tableColumns);
    $columnsBinds = $this->getColumnsFromArray(", :", $tableColumns);

    $this->insert = "INSERT INTO " . $this->tableInfoInterface->getDataBaseName() . $this->tableInfoInterface->getTableName() . " ({$columns}) VALUES ({$columnsBinds}) ";
  }

  public function getUpdate(): ?string
  {
    return $this->update;
  }

  public function setUpdate(array $tableColumns = null): void
  {
    $columns = $this->getColumnsToUpdate($tableColumns);

    $this->update = "UPDATE " . $this->tableInfoInterface->getDataBaseName() . $this->tableInfoInterface->getTableName() . " SET {$columns} ";
  }

  public function getDelete(): ?string
  {
    return $this->delete;
  }

  public function setDelete(int $tableIdentifier): void
  {
    $this->delete = "DELETE " . $this->tableInfoInterface->getDataBaseName() . $this->tableInfoInterface->getTableName() . self::SPACE_SEPARATOR;
  }

  public function getTableIdentifier(): ?string
  {
    $identifierValue = self::SPACE_SEPARATOR;

    if (!(isset($this->tableIdentifier))) {
      $identifierValue = " AND " . $this->tableInfoInterface->getTableIdentifier() . " = {$this->tableIdentifier} ";
    }

    return $identifierValue;
  }

  public function setTableIdentifier(int $tableIdentifier): void
  {
    $this->tableIdentifier = $tableIdentifier;
  }

  public function clean(): void
  {
    $this->tableIdentifier = null;

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
    $tableColumns = empty($tableColumns) ? $this->tableInfoInterface->getTableColumns() : $tableColumns;
    return strtoupper(join($separator, $tableColumns));
  }

  private function getColumnsToUpdate(array $tableColumns = null): string
  {
    $columnsUpdate = array();
    $tableColumns = empty($tableColumns) ? $this->tableInfoInterface->getTableColumns() : $tableColumns;

    foreach ($tableColumns as $column) {
      array_push($columnsUpdate, " {$column} = :{$column} ");
    }

    return strtoupper(join(", ", $columnsUpdate));
  }
}
