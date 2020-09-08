<?php

namespace core\interfaces\Helpers;

use core\Interfaces\{
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

/**
 * @method __construct(QuerySqlStringInterface $querySqlStringInterface, RepositoryDataDBInterface $repositoryDataDBInterface)
 */
interface QueryDataHelper
{
  public function __construct(QuerySqlStringInterface $querySqlStringInterface, RepositoryDataDBInterface $repositoryDataDBInterface);
}
