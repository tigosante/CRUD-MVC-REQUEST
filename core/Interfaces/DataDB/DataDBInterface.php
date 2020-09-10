<?php

namespace core\Interfaces\DataDB;

use core\interfaces\{
  Helpers\QueryDataHelper,
  DataDB\FindAllDataInterface
};

interface DataDBInterface extends QueryDataHelper, FindAllDataInterface
{
  public function delete(int $tableIdentifier): bool;
  public function update(array $tableColumns = null): bool;

  public function where(string $conditions): self;
}
