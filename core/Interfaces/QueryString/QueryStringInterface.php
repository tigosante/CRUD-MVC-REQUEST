<?php

namespace core\Interfaces\QueryString;

use core\interfaces\TableObject\TableObjectHelperInterface;

interface QueryStringInterface
{
  public function __construct(TableObjectHelperInterface $tableObjectHelperInterface);

  public function insert(array $tableColumns = null): string;
  public function select(array $tableColumns = null): string;
  public function update(array $tableColumns = null): string;
  public function delete(): string;
  public function where(string $conditions, bool $isFindBySQ = false): string;
}
