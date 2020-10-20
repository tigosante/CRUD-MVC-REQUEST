<?php

namespace src\interfaces\Helpers;

use src\Interfaces\{
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

interface QueryDataHelper
{
  /**
   * @return self
   */
  public static function config(QuerySqlStringInterface &$querySqlStringInterface, RepositoryDataDBInterface &$repositoryDataDBInterface): self;
}
