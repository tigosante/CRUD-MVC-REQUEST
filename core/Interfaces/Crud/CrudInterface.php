<?php

namespace core\interfaces\Crud;

interface CrudInterface
{
  public function select(): self;
  public function join(): self;
  public function where(): self;
  public function groupBy(): self;
  public function orderBy(): self;
}
