<?php

namespace src\interfaces\TableObject;

interface TableInfoInterface
{
  public function getDataBaseName(): string;
  public function setDataBaseName(string $dataBaseName): void;

  public function getTableName(): string;
  public function setTableName(string $tableName): void;

  public function getTableIdentifier(): string;
  public function setTableIdentifier(string $tableIdentifier = null): void;

  public function getTableColumns(): array;
  public function setTableColumns(array $tableColumns): void;

  public function getTableColumnsDate(): array;
  public function setTableColumnsDate(array $tableColumnsDate = null): void;
}
