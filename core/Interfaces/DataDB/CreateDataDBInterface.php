<?php

namespace core\interfaces\DataDB;

use core\interfaces\Helpers\{
  QueryDataHelper
};

interface CreateDataDBInterface extends QueryDataHelper
{
  public function create(array $tableColumns = null): bool;
}
