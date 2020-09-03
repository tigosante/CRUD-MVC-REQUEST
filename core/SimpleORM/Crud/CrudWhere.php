<?php

namespace core\interfaces\Crud;

use core\interfaces\Crud\{CrudWhereInterface, CrudHandlerDataInterface};

class CrudWhere implements CrudWhereInterface
{
  /**
   * @var CrudHandlerDataInterface $crudHandlerDataInterface
   */
  private $crudHandlerDataInterface;

  public function __construct(CrudHandlerDataInterface $crudHandlerDataInterface)
  {
    $this->crudHandlerDataInterface = $crudHandlerDataInterface;
  }

  public function where(string $conditions): CrudHandlerDataInterface
  {
    return $this->crudHandlerDataInterface;
  }
}
