<?php

namespace core\interfaces\Helpers;

use core\Interfaces\{
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

interface QueryDataHelper
{
  public function __construct(QuerySqlStringInterface &$querySqlStringInterface, RepositoryDataDBInterface &$repositoryDataDBInterface);
}
