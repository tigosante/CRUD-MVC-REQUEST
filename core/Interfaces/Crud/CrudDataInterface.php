<?php

namespace core\interfaces\Crud;

interface CrudDataInterface
{
  public function create(array $tableColumns = null): bool;
  public function find(array $tableColumns = null): array;
  public function findBySq(int $tableSq, array $tableColumns = null): array;
  public function update(array $tableColumns = null): bool;
  public function delete(int $tableSq): bool;
}
