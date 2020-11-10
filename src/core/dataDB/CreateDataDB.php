<?php

namespace src\core\dataDB;

use src\interfaces\{
  DataDB\CreateDataDBInterface,
  DataObject\DataObjectInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

class CreateDataDB implements CreateDataDBInterface
{
  private static DataObjectInterface $dataObject;
  private static QuerySqlStringInterface $querySqlString;
  private static RepositoryDataDBInterface $repositoryDataDB;

  public static function config(DataObjectInterface &$dataObject, QuerySqlStringInterface &$querySqlString, RepositoryDataDBInterface &$repositoryDataDB): self
  {
    self::$dataObject = $dataObject;
    self::$querySqlString = $querySqlString;
    self::$repositoryDataDB = $repositoryDataDB;

    return new self;
  }

  public function create(array $tableColumns = null): bool
  {
    self::$querySqlString->setInsert($tableColumns);

    self::$repositoryDataDB->setData(self::$dataObject->getData(self::$querySqlString->getTableColumnsData()));
    self::$repositoryDataDB->setQuery(self::$querySqlString->getInsert());

    return self::$repositoryDataDB->handleData();
  }
}
