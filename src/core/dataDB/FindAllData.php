<?php

namespace src\core\dataDB;

use src\interfaces\DataDB\FindAllDataInterface;
use src\interfaces\QuerySql\QuerySqlStringInterface;
use src\interfaces\Repository\RepositoryDataDBInterface;

class FindAllData implements FindAllDataInterface
{
  private static QuerySqlStringInterface $querySqlString;
  private static RepositoryDataDBInterface $repositoryDataDB;

  public static function config(QuerySqlStringInterface &$querySqlString, RepositoryDataDBInterface &$repositoryDataDB): self
  {
    self::$querySqlString = $querySqlString;
    self::$repositoryDataDB = $repositoryDataDB;

    return new self;
  }

  public function findAll(array $tableColumns = null): array
  {
    self::$querySqlString->setSelect($tableColumns);
    self::$repositoryDataDB->setQuery(self::$querySqlString->getSelect());

    return self::$repositoryDataDB->recoverData();
  }
}
