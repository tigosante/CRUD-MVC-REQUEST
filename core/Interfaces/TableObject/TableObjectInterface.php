<?php

namespace core\interfaces\TableObject;

interface TableObjectInterface
{
  public function cleanData(string $tableColumnName): bool;
  public function cleanAllData(): bool;

  public function setData(string $tableColumnName): bool;
  public function setAllData(): bool;

  public function setAllDataFromArray(array $dataArray): bool;
}
