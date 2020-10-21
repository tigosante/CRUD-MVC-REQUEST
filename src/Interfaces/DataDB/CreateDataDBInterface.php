<?php

namespace src\interfaces\DataDB;

use src\interfaces\{
  DataObject\DataObjectInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

interface CreateDataDBInterface
{
  public static function config(DataObjectInterface $dataObject, QuerySqlStringInterface &$querySqlString, RepositoryDataDBInterface &$repositoryDataDB): self;

  /**
   * @return bool
   */
  public function create(array $tableColumns = null): bool;
}
