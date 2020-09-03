<?php

namespace core\SimpleORM\TableObject;

use core\interfaces\Helpers\TableObjectHelperInterface;

class TableObjectHelper implements TableObjectHelperInterface
{
  /**
   * @var int $tableSq
   */
  private $tableSq;

  /**
   * @var string $tabelName
   */
  private $tabelName;

  /**
   * @var string $dataBaseName
   */
  private $dataBaseName;

  /**
   * @var array $tabelColumns
   */
  private $tabelColumns;


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
    return $this->tabelName;
  }

  public function setTableName(string $tabelName): void
  {
    $this->tabelName = $tabelName;
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
    return $this->tabelColumns;
  }

  public function setTableColumns(array $tabelColumns): void
  {
    $this->tabelColumns = $tabelColumns;
  }
}
