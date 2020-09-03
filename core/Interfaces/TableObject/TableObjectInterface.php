<?php

namespace core\interfaces\TableObject;

interface TableObjectInterface
{
  public function setData(string $tableColumnName): bool;
  public function setAllData(): bool;
  public function setAllDataFromArray(array $dataArray): bool;
}
