<?php

namespace core\Interfaces\DataDB;

use core\interfaces\Helpers\{
  QueryDataHelper
};

interface FindDataInterface extends QueryDataHelper
{
  public function find(int $tableIdentifier, array $tableColumns = null): array;
}
