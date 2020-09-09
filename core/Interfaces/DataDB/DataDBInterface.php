<?php

namespace core\Interfaces\DataDB;

use core\interfaces\Helpers\{
  SetDataHelper,
  QueryDataHelper
};

use core\interfaces\DataDB\{
  FindDataInterface,
  FindAllDataInterface
};

interface DataDBInterface extends QueryDataHelper, SetDataHelper, FindAllDataInterface
{
  public function delete(int $tableIdentifier): bool;
  public function update(array $tableColumns = null): bool;

  public function where(string $conditions): self;
}
