<?php

namespace core\interfaces\TableObject;

interface TableObjectInterface
{
  public function __construct(object $object);
  public function setAllData(): bool;
  public function setAllDataFromArray(array $dataArray): bool;
}
