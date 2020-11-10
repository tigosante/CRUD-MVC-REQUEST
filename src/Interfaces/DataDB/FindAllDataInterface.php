<?php

namespace src\interfaces\dataDB;

use src\interfaces\{
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

interface FindAllDataInterface
{
  /**
   * @return self
   */
  public static function config(QuerySqlStringInterface &$querySqlString, RepositoryDataDBInterface &$repositoryDataDB): self;

  /**
   * @return array
   */
  public function findAll(array $tableColumns = null): array;
}
