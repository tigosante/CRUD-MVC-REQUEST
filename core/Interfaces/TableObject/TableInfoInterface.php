<?php

namespace core\interfaces\TableObject;

/**
 * @method getDataBaseName(): string;
 * @method setDataBaseName(string $dataBaseName): void;
 * @method getTableName(): string;
 * @method setTableName(string $tableName): void;
 * @method getTableIdentifier(): int;
 * @method setTableIdentifier(int $tableIdentifier = null): void;
 * @method getTableColumns(): array;
 * @method setTableColumns(array $tableColumns): void;
 */
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
