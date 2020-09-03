<?php

namespace core\interfaces\Crud;

use core\Interfaces\QueryString\QueryStringInterface;
use core\interfaces\Repository\RepositoryHandlerDataInterface;

interface CrudHandlerDataInterface
{
  public function __construct(QueryStringInterface $queryStringInterface, RepositoryHandlerDataInterface $repositoryHandlerDataInterface);

  public function update(array $tableColumns = null): bool;
  public function delete(int $tableSq): bool;

  public function setData(array $data): void;
}
