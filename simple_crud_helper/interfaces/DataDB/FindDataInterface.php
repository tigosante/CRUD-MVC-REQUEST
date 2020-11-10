<?php

namespace core\classes\interfaces\DataDB;

use core\classes\interfaces\{
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface,
  TableObject\TableObjectInfoInterface
};

interface FindDataInterface
{
  /**
   * @return self
   */
  public static function config(QuerySqlStringInterface &$querySqlString, TableObjectInfoInterface &$tableObjectInfo, RepositoryDataDBInterface &$repositoryDataDB);

  /**
   * @return array
   */
  public function find(int $tableIdentifier, array $tableColumns = null);
}
