<?php

namespace core\interfaces\Crud;

use core\interfaces\Crud\CrudHandlerDataInterface;

interface CrudWhereInterface
{
  public function __construct(CrudHandlerDataInterface $crudHandlerDataInterface);
  public function where(string $conditions): CrudHandlerDataInterface;
}
