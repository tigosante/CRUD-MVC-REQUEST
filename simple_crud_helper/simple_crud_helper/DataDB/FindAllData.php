<?php

namespace core\classes\simple_crud_helper\DataDB;

use core\classes\interfaces\DataDB\FindAllDataInterface;
use core\classes\interfaces\QuerySql\QuerySqlStringInterface;
use core\classes\interfaces\Repository\RepositoryDataDBInterface;

class FindAllData implements FindAllDataInterface
{
  /**
   * @var QuerySqlStringInterface $querySqlString
   */
  private static $querySqlString;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDB
   */
  private static $repositoryDataDB;

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
