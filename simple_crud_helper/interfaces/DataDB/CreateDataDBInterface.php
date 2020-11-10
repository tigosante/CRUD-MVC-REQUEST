<?php

namespace core\classes\interfaces\DataDB;

use core\classes\interfaces\{
  DataObject\DataObjectInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

interface CreateDataDBInterface
{
  /**
   * @return self
   */
  public static function config(DataObjectInterface &$dataObject, QuerySqlStringInterface &$querySqlString, RepositoryDataDBInterface &$repositoryDataDB);

  /**
   * @return bool
   */
  public function create(array $tableColumns = null);
}
