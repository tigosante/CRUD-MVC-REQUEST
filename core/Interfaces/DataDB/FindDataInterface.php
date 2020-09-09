<?php

namespace core\Interfaces\DataDB;

use core\interfaces\Helpers\{
  SetDataHelper,
  QueryDataHelper
};

interface FindDataInterface extends QueryDataHelper, SetDataHelper
{
  public function find(int $tableIdentifier, array $tableColumns = null): array;
}
