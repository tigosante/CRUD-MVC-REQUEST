<?php

namespace core\interfaces\Helpers;

interface TableObjectHelperInterface
{
  public function getDataBase(): string;
  public function setDataBase(string $dataBaseName): void;

  public function getTableName(): string;
  public function setTableName(string $tabelName): void;

  public function getTableSq(): int;
  public function setTableSq(int $tableSq): void;

  public function getTableColumns(): array;
  public function setTableColumns(array $tableSq): void;
}
