<?php

namespace core\SimpleORM\Crud;

use core\interfaces\Crud\CrudDataInterface as CrudDataInterface;
use core\MVC\Model;

class CrudData extends Model implements CrudDataInterface
{
  public function create(array $tableColumns = null): bool
  {
    return true;
  }

  public function find(array $tableColumns = null): array
  {
    return array();
  }

  public function findBySq(int $tableSq, array $tableColumns = null): array
  {
    return array();
  }

  public function update(array $tableColumns = null): bool
  {
    return true;
  }

  public function delete(int $tableSq): bool
  {
    return true;
  }
}
