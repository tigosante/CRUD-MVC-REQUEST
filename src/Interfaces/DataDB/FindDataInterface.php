<?php

namespace src\Interfaces\DataDB;

use src\interfaces\Helpers\{
  QueryDataHelper
};

interface FindDataInterface extends QueryDataHelper
{
  public function find(int $tableIdentifier, array $tableColumns = null): array;
}
