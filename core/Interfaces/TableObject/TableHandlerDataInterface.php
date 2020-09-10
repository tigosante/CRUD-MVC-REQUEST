<?php

namespace core\Interfaces\Table;

interface TableHandlerDataInterface
{
  public function setAllData(bool $isDataToTableDataBase = true): bool;
  public function setDataFromArray(array $dataArray, bool $isDataToTableDataBase = true): bool;
  public function getArrayObjectFromDB(array $dataArray): array;
}
