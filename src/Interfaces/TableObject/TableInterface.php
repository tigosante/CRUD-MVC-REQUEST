<?php

namespace src\interfaces\TableObject;

use src\Interfaces\{
  DataDB\DataDBInterface,
  DataDB\FindDataInterface,
  DataDB\FindAllDataInterface,
  DataDB\CreateDataDBInterface,
  QuerySql\QuerySqlInterface,
  Pagination\PaginationInterface,
  Table\TableHandlerDataInterface,
  Helpers\SetDataHelper
};

interface TableInterface extends FindDataInterface, FindAllDataInterface, CreateDataDBInterface, SetDataHelper, TableHandlerDataInterface
{
  public function __construct(object &$object, array $tableConfiguration, array $objectsConfiguration = array());

  public static function singleton(array $args = null): self;

  public function ignoreViewField(array $ignore = null): void;

  public function select(array $tableColumns = null): QuerySqlInterface;

  public function where(string $conditions): DataDBInterface;

  public function pagination(int $paginationInit = null, int $paginationAmount = null, int $paginationEnd = null): PaginationInterface;

  public function setData(array $data): void;

  public function clean(): void;
}
