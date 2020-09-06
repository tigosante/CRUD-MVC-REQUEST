<?php

namespace core\SimpleORM\QueryString;

use core\Interfaces\{
  QueryString\QueryStringInterface,
  TableObject\TableObjectHelperInterface
};

class QueryString implements QueryStringInterface
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
   * @var int $tableSq
   */
  private $tableSq = null;

  /**
   * @var string $tableName
   */
  private $tableName = null;

  /**
   * @var array $tableColumns
   */
  private $tableColumns = null;

  public function __construct(TableObjectHelperInterface $tableObjectHelperInterface)
  {
    $this->tableObjectHelperInterface = $tableObjectHelperInterface;

    $this->dataBaseName = $tableObjectHelperInterface->getDataBaseName();
    $this->tableName = $tableObjectHelperInterface->getTableName();
    $this->tableSq = $tableObjectHelperInterface->getTableSq();
    $this->tableColumns = $tableObjectHelperInterface->getTableColumns();
  }

  public function insert(array $tableColumns = null): string
  {
    $columns = $this->getColumnsFromArray(", ", $tableColumns);
    $columnsBinds = $this->getColumnsFromArray(", :", $tableColumns);

    return "INSERT INTO {$this->dataBaseName}{$this->tableName} ({$columns}) VALUES ({$columnsBinds}) ";
  }

  public function select(array $tableColumns = null): string
  {
    $columns = $tableColumns ? join(", ", $tableColumns) : "*";

    return "SELECT {$columns} FROM {$this->dataBaseName}{$this->tableName} ";
  }

  public function update(array $tableColumns = null): string
  {
    $columns = $this->getColumnsToUpdate($tableColumns);

    return "UPDATE {$this->dataBaseName}{$this->tableName} SET {$columns} ";
  }

  public function delete(): string
  {
    return "DELETE {$this->dataBaseName}{$this->tableName} ";
  }

  public function where(string $conditions, bool $isFindBySQ = false): string
  {
    return "WHERE 1=1 " . $isFindBySQ ? " AND {$this->tableSq}" . $conditions : $conditions;
  }

  private function getColumnsFromArray(string $separator, array $tableColumns = null): string
  {
    $tableColumns = $tableColumns ?? $this->tableColumn;

    return join($separator, $tableColumns);
  }

  private function getColumnsToUpdate(array $tableColumns = null): string
  {
    $columnsUpdate = "";
    $tableColumns = $tableColumns ?? $this->tableColumn;

    foreach ($tableColumns as $column) {
      $columnsUpdate .= "{$column} = :{$column}";
    }

    return $columnsUpdate;
  }
}
