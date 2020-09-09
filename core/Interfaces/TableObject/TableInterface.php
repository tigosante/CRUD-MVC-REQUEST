<?php

namespace core\interfaces\TableObject;

use core\Interfaces\{
  DataDB\DataDBInterface,
  QuerySql\QuerySqlInterface
};
use core\Interfaces\Pagination\PaginationInterface;

interface TableInterface
{
  public function __construct(array $tableConfig, object $object);

  public function setAllData(bool $isDataToTableDataBase = true): bool;
  public function setDataFromArray(array $dataArray, bool $isDataToTableDataBase = true): bool;
  public function ignoreInArray(array $ignore): void;

  public function select(array $tableColumns = null): QuerySqlInterface;

  public function where(string $conditions): DataDBInterface;

  public function create(array $tableColumns = null): bool;

  public function find(int $tableIdentifier, array $tableColumns = null): array;
  public function findAll(array $tableColumns = null): array;

  public function pagination(int $paginationInit = null, int $paginationAmount = null, int $paginationEnd = null): PaginationInterface;

  public function setData(array $data): void;

  public function clean(): void;
}
