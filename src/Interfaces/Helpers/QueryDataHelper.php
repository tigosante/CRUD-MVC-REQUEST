<?php

namespace src\interfaces\Helpers;

use src\Interfaces\{
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

interface QueryDataHelper
{
  public function __construct(QuerySqlStringInterface &$querySqlStringInterface, RepositoryDataDBInterface &$repositoryDataDBInterface);
}
