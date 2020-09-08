<?php

namespace core\Interfaces\DataDB;

use core\interfaces\Helpers\{
  SetDataHelper,
  QueryDataHelper
};

/**
 * @method find(int $tableIdentifier, array $tableColumns = null): array
 * @method findAll(array $tableColumns = null): array
 * @method delete(int $tableIdentifier): bool
 * @method update(array $tableColumns = null): bool
 * @method where(string $conditions): self
 */
interface DataDBInterface extends QueryDataHelper, SetDataHelper
{
  public function find(int $tableIdentifier, array $tableColumns = null): array;
  public function findAll(array $tableColumns = null): array;

  public function delete(int $tableIdentifier): bool;
  public function update(array $tableColumns = null): bool;

  public function where(string $conditions): self;
}
