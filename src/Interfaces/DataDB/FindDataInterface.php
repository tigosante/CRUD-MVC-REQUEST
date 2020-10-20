<?php

namespace src\Interfaces\DataDB;

use src\Interfaces\{
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface,
  TableObject\TableInfoInterface
};

interface FindDataInterface
{
  /**
   * @return self
   */
  public static function config(QuerySqlStringInterface &$querySqlStringInterface, TableInfoInterface &$tableInfoInterface, RepositoryDataDBInterface &$repositoryDataDBInterface): self;

  /**
   * @return array
   */
  public function find(int $tableIdentifier, array $tableColumns = null): array;
}
