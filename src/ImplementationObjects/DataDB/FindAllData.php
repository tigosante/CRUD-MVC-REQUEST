<?php

namespace src\ImplementationObjects\DataDB;

use src\Interfaces\DataDB\FindAllDataInterface;
use src\Interfaces\QuerySql\QuerySqlStringInterface;
use src\interfaces\Repository\RepositoryDataDBInterface;

class FindAllData implements FindAllDataInterface
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

  public function findAll(array $tableColumns = null): array
  {
    self::$querySqlStringInterface->setSelect($tableColumns);
    self::$repositoryDataDBInterface->setQuery(self::$querySqlStringInterface->getSelect());

    return self::$repositoryDataDBInterface->recoverData();
  }
}
