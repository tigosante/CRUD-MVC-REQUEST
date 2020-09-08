<?php

namespace core\SimpleORM\TableObject;

use core\interfaces\TableObject\TableInfoInterface;

/**
 * @method getDataBaseName(): string
 * @method setDataBaseName(string $dataBaseName): void
 * @method getTableName(): string
 * @method setTableName(string $tableName): void
 * @method getTableIdentifier(): int
 * @method setTableIdentifier(int $tableIdentifier = null): void
 * @method getTableColumns(): array
 * @method setTableColumns(array $tableColumns): void
 */
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
   * @var int $tableIdentifier
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

  public function getTableIdentifier(): int
  {
    return $this->tableIdentifier;
  }
  public function setTableIdentifier(int $tableIdentifier = null): void
  {
    if ($tableIdentifier !== null) {
      $this->tableIdentifier = $tableIdentifier;
    }
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
