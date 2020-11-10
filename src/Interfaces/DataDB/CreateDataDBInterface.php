<?php

namespace src\interfaces\dataDB;

use src\interfaces\{
  DataObject\DataObjectInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

interface CreateDataDBInterface
{
  /**
   * @return self
   */
  public static function config(DataObjectInterface &$dataObject, QuerySqlStringInterface &$querySqlString, RepositoryDataDBInterface &$repositoryDataDB): self;

  /**
   * @return bool
   */
  public function create(array $tableColumns = null): bool;
}
