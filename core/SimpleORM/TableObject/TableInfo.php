<?php

namespace core\SimpleORM\TableObject;

use core\interfaces\TableObject\TableInfoInterface;

class TableInfo implements TableInfoInterface
{
  /**
   * @var string $dataBaseName
   */
  private $dataBaseName = null;

  /**
   * @var string $tableName
   */
  private $tableName = null;

  /**
   * @var string $tableIdentifier
   */
  private $tableIdentifier = null;

  /**
   * @var array $tableColumns
   */
  private $tableColumns = null;

  public function getDataBaseName(): string
  {
    return $this->dataBaseName;
  }
  public function setDataBaseName(string $dataBaseName): void
  {
    $this->dataBaseName = $dataBaseName;
  }

  public function getTableName(): string
  {
    return $this->tableName;
  }
  public function setTableName(string $tableName): void
  {
    $this->tableName = $tableName;
  }

  public function getTableIdentifier(): string
  {
    return $this->tableIdentifier !== null ? $this->tableIdentifier : "";
  }
  public function setTableIdentifier(string $tableIdentifier = null): void
  {
    $this->tableIdentifier = $tableIdentifier;
  }

  public function getTableColumns(): array
  {
    return $this->tableColumns;
  }
  public function setTableColumns(array $tableColumns): void
  {
    $this->tableColumns = $tableColumns;
  }
}
