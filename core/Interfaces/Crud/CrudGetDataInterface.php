<?php

namespace core\interfaces\Crud;

use core\Interfaces\QueryString\QueryStringInterface;
use core\interfaces\Repository\RepositoryGetDataInterface;

interface CrudGetDataInterface
{
  public function __construct(QueryStringInterface $queryStringInterface, RepositoryGetDataInterface $repositoryGetDataInterface);

  public function findAll(array $tableColumns = null): array;
  public function findBySq(int $tableSq, array $tableColumns = null): array;

  public function setData(array $data): void;
}
