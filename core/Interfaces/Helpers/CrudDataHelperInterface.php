<?php

namespace core\interfaces\Helpers;

interface CrudHelperInterface
{
  public function getData(): array;
  public function getAllData(): array;
  public function executeCommand(): bool;
}
