<?php

namespace src\core\table;

use src\interfaces\TableObject\TableObjectInfoInterface;

class TableObjectInfo implements TableObjectInfoInterface
{
  private string $tableName = "";
  private string $dataBaseName = "";
  private string $tableIdentifier = "";
  private array $tableColumns = array();
  private array $tableColumnsDate = array();

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
    return $this->tableIdentifier;
  }

  public function setTableIdentifier(string $tableIdentifier = null): void
  {
    $this->tableIdentifier = $tableIdentifier;
  }

  public function getTableColumns(): array
  {
    return  $this->tableColumns;
  }

  public function setTableColumns(array $tableColumns): void
  {
    $this->tableColumns = $tableColumns;
  }

  public function getTableColumnsDate(): array
  {
    return $this->tableColumnsDate;
  }

  public function setTableColumnsDate(array $tableColumnsDate = array()): void
  {
    $this->tableColumnsDate = $tableColumnsDate;
  }
}
