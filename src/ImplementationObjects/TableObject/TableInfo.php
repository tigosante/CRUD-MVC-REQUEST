<?php

namespace src\ImplementationObjects\TableObject;

use src\interfaces\TableObject\TableInfoInterface;

class TableInfo implements TableInfoInterface
{
  /**
   * @var string $dataBaseName
   */
  private $dataBaseName = "";

  /**
   * @var string $tableName
   */
  private $tableName = "";

  /**
   * @var string $tableIdentifier
   */
  private $tableIdentifier = "";

  /**
   * @var array $tableColumns
   */
  private $tableColumns = array();

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
    return  $this->tableIdentifier;
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
