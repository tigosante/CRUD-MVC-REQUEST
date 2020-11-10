<?php

namespace src\interfaces\pagination;

use src\interfaces\{
  Helpers\SetDataHelper,
  QuerySql\QuerySqlInterface,
  DataDB\FindAllDataInterface,
  QuerySql\QuerySqlStringInterface
};

interface PaginationInterface extends SetDataHelper
{
  /**
   * @return self
   */
  public static function config(QuerySqlInterface &$querySql, FindAllDataInterface &$findAllData, QuerySqlStringInterface &$querySqlString): self;

  /**
   * @return self
   */
  public function init(int $paginationInit = null): self;
  /**
   * @return self
   */
  public function amount(int $paginationAmount = null): self;
  /**
   * @return self
   */
  public function end(int $paginationEnd = null): self;

  /**
   * @return array
   */
  public function findAll(array $tableColumns = null): array;
  /**
   * @return QuerySqlInterface
   */
  public function select(array $tableColumns = null): QuerySqlInterface;
  /**
   * @return FindAllDataInterface
   */
  public function where(string $condition): FindAllDataInterface;
}
