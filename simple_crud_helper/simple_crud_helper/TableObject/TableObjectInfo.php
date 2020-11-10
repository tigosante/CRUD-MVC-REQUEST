<?php

namespace core\classes\simple_crud_helper\TableObject;

use core\classes\interfaces\TableObject\TableObjectInfoInterface;

class TableObjectInfo implements TableObjectInfoInterface
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

  /**
   * @var array $tableColumnsDate
   */
  private $tableColumnsDate = array();

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
