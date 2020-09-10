<?php

namespace core\Interfaces\DataDB;

use core\interfaces\{
  Helpers\QueryDataHelper,
  DataDB\FindAllDataInterface
};
use core\interfaces\Helpers\SetDataHelper;

interface DataDBInterface extends QueryDataHelper, SetDataHelper, FindAllDataInterface
{
  public function delete(int $tableIdentifier): bool;
  public function update(array $tableColumns = null): bool;

  public function where(string $conditions): self;
}
