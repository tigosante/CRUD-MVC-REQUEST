<?php

namespace core\interfaces\DataDB;

use core\interfaces\Helpers\{
  QueryDataHelper,
  SetDataHelper
};

interface CreateDataDBInterface extends QueryDataHelper, SetDataHelper
{
  public function create(array $tableColumns = null): bool;
}
