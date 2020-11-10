<?php

namespace src\interfaces\dataDB;

use src\interfaces\{
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface,
  TableObject\TableObjectInfoInterface
};

interface FindDataInterface
{
  /**
   * @return self
   */
  public static function config(QuerySqlStringInterface &$querySqlString, TableObjectInfoInterface &$tableObjectInfo, RepositoryDataDBInterface &$repositoryDataDB): self;

  /**
   * @return array
   */
  public function find(int $tableIdentifier, array $tableColumns = null): array;
}
