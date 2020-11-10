<?php

namespace core\classes\interfaces\Pagination;

use core\classes\interfaces\{
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
  public static function config(QuerySqlInterface &$querySql, FindAllDataInterface &$findAllData, QuerySqlStringInterface &$querySqlString);

  /**
   * @return self
   */
  public function init(int $paginationInit = null);
  /**
   * @return self
   */
  public function amount(int $paginationAmount = null);
  /**
   * @return self
   */
  public function end(int $paginationEnd = null);

  /**
   * @return array
   */
  public function findAll(array $tableColumns = null);
  /**
   * @return QuerySqlInterface
   */
  public function select(array $tableColumns = null);
  /**
   * @return FindAllDataInterface
   */
  public function where(string $condition);
}
