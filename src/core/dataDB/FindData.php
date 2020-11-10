<?php

namespace src\core\dataDB;

use src\interfaces\DataDB\FindDataInterface;
use src\interfaces\QuerySql\QuerySqlStringInterface;
use src\interfaces\Repository\RepositoryDataDBInterface;
use src\interfaces\TableObject\TableObjectInfoInterface;

class FindData implements FindDataInterface
{
  private static QuerySqlStringInterface $querySqlString;
  private static TableObjectInfoInterface $tableObjectInfo;
  private static RepositoryDataDBInterface $repositoryDataDB;

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
