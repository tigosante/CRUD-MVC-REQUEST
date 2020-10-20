<?php

namespace src\ImplementationObjects\DataDB;

use src\interfaces\{
  DataDB\CreateDataDBInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

class CreateDataDB implements CreateDataDBInterface
{
  /**
   * @var QuerySqlStringInterface $querySqlStringInterface
   */
  private static $querySqlStringInterface;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDBInterface
   */
  private static $repositoryDataDBInterface;

  public static function config(QuerySqlStringInterface &$querySqlStringInterface, RepositoryDataDBInterface &$repositoryDataDBInterface): self
  {
    self::$querySqlStringInterface = $querySqlStringInterface;
    self::$repositoryDataDBInterface = $repositoryDataDBInterface;

    return new self;
  }

  public function create(array $tableColumns = null): bool
  {
    self::$querySqlStringInterface->setInsert($tableColumns);
    self::$repositoryDataDBInterface->setQuery(self::$querySqlStringInterface->getInsert());

    return self::$repositoryDataDBInterface->handleData();
  }
}
