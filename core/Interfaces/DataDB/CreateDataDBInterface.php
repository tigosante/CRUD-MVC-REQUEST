<?php

namespace core\interfaces\DataDB;

use core\interfaces\Helpers\{
  SetDataHelper,
  QueryDataHelper
};

/**
 * @method create(array $tableColumns = null): bool
 */
interface CreateDataDBInterface extends QueryDataHelper, SetDataHelper
{
  public function create(array $tableColumns = null): bool;
}
