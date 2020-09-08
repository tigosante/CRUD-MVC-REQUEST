<?php

namespace core\Interfaces\DataDB;

use core\interfaces\Helpers\{
  QueryDataHelper,
  SetDataHelper
};

interface DataDBInterface extends QueryDataHelper, SetDataHelper
{
  public function find(int $tableIdentifier, array $tableColumns = null): array;
  public function findAll(array $tableColumns = null): array;

  public function delete(int $tableIdentifier): bool;
  public function update(array $tableColumns = null): bool;

  public function where(string $conditions): self;
}
