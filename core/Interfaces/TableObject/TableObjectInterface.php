<?php

namespace core\interfaces\TableObject;

interface TableObjectInterface
{
  public function loadData(): bool;
  public function cleanData(): bool;
  public function loadDataFromArray(array $dataArray): bool;
}
