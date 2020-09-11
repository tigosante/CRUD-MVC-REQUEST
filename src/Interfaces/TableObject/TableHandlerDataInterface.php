<?php

namespace src\Interfaces\Table;

interface TableHandlerDataInterface
{
  public function setAllData(bool $isDataToTableDataBase = true): bool;
  public function setDataFromArray(array $dataArray, bool $isDataToTableDataBase = false): bool;
  public function getArrayObjectFromDB(array $dataArray): array;
}
