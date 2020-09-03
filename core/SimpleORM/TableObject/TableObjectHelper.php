<?php

namespace core\SimpleORM\TableObject;

use core\interfaces\TableObject\TableObjectHelperInterface;

class TableObjectHelper implements TableObjectHelperInterface
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
   * @var int $tableSq
   */
  private $tableSq = null;

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

  public function getTableSq(): int
  {
    return $this->tableSq;
  }
  public function setTableSq(int $tableSq): void
  {
    $this->tableSq = $tableSq;
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
