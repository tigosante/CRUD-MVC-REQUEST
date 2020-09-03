<?php

namespace core\interfaces\TableObject;

interface TableObjectHelperInterface
{
  public function getDataBaseName(): string;
  public function setDataBaseName(string $dataBaseName): void;

  public function getTableName(): string;
  public function setTableName(string $tableName): void;

  public function getTableSq(): int;
  public function setTableSq(int $tableSq = null): void;

  public function getTableColumns(): array;
  public function setTableColumns(array $tableColumns): void;
}
