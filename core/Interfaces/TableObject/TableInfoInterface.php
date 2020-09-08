<?php

namespace core\interfaces\TableObject;

interface TableInfoInterface
{
  public function getDataBaseName(): string;
  public function setDataBaseName(string $dataBaseName): void;

  public function getTableName(): string;
  public function setTableName(string $tableName): void;

  public function getTableIdentifier(): int;
  public function setTableIdentifier(int $tableIdentifier = null): void;

  public function getTableColumns(): array;
  public function setTableColumns(array $tableColumns): void;
}
