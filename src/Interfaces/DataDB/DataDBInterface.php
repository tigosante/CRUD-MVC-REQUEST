<?php

namespace src\Interfaces\DataDB;

use src\interfaces\{
  Helpers\QueryDataHelper,
  DataDB\FindAllDataInterface
};
use src\interfaces\Helpers\SetDataHelper;

interface DataDBInterface extends QueryDataHelper, SetDataHelper, FindAllDataInterface
{
  public function delete(int $tableIdentifier): bool;
  public function update(array $tableColumns = null): bool;

  public function where(string $conditions): self;
}
