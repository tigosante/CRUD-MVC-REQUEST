<?php

namespace src\Interfaces\DataDB;

use src\interfaces\Helpers\QueryDataHelper;

interface FindAllDataInterface extends QueryDataHelper
{
  /**
   * @return array
   */
  public function findAll(array $tableColumns = null): array;
}
