<?php

namespace core\interfaces\TableObject;

use core\Interfaces\{
  DataDB\DataDBInterface,
  DataDB\FindDataInterface,
  DataDB\FindAllDataInterface,
  DataDB\CreateDataDBInterface,
  QuerySql\QuerySqlInterface,
  Pagination\PaginationInterface,
  Table\TableHandlerDataInterface
};

interface TableInterface extends FindDataInterface, FindAllDataInterface, CreateDataDBInterface, TableHandlerDataInterface
{
  public function __construct(array $tableConfig, object $object);

  public function ignoreInArray(array $ignore): void;

  public function select(array $tableColumns = null): QuerySqlInterface;

  public function where(string $conditions): DataDBInterface;

  public function pagination(int $paginationInit = null, int $paginationAmount = null, int $paginationEnd = null): PaginationInterface;

  public function setData(array $data): void;

  public function clean(): void;
}
