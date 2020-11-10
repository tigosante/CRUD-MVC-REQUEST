<?php

namespace core\classes\interfaces\DataDB;

use core\classes\interfaces\{
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

interface FindAllDataInterface
{
  /**
   * @return self
   */
  public static function config(QuerySqlStringInterface &$querySqlString, RepositoryDataDBInterface &$repositoryDataDB);

  /**
   * @return array
   */
  public function findAll(array $tableColumns = null);
}
