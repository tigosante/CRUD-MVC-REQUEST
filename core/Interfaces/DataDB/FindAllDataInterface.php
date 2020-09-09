<?php

namespace core\Interfaces\DataDB;

use core\interfaces\Helpers\QueryDataHelper;

interface FindAllDataInterface extends QueryDataHelper
{
  public function findAll(array $tableColumns = null): array;
}
