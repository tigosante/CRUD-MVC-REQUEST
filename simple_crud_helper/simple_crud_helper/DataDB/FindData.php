<?php

namespace core\classes\simple_crud_helper\DataDB;

use core\classes\interfaces\DataDB\FindDataInterface;
use core\classes\interfaces\QuerySql\QuerySqlStringInterface;
use core\classes\interfaces\Repository\RepositoryDataDBInterface;
use core\classes\interfaces\TableObject\TableObjectInfoInterface;

class FindData implements FindDataInterface
{
  /**
   * @var TableObjectInfoInterface $tableObjectInfo
   */
  private static $tableObjectInfo;

  /**
   * @var QuerySqlStringInterface $querySqlString
   */
  private static $querySqlString;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDB
   */
  private static $repositoryDataDB;

  public static function config(QuerySqlStringInterface &$querySqlString, TableObjectInfoInterface &$tableObjectInfo, RepositoryDataDBInterface &$repositoryDataDB): self
  {
    self::$tableObjectInfo = $tableObjectInfo;
    self::$querySqlString = $querySqlString;
    self::$repositoryDataDB = $repositoryDataDB;

    return new self;
  }

  public function find(int $tableIdentifier, array $tableColumns = null): array
  {
    $tableIdentifierName = self::$tableObjectInfo->getTableIdentifier();

    self::$querySqlString->setSelect($tableColumns);
    self::$querySqlString->setWhere("{$tableIdentifierName} = :{$tableIdentifierName}");
    self::$repositoryDataDB->setData([$tableIdentifierName => $tableIdentifier]);
    self::$repositoryDataDB->setQuery(self::$querySqlString->getSelect() . self::$querySqlString->getWhere());

    return self::$repositoryDataDB->recoverData();
  }
}
