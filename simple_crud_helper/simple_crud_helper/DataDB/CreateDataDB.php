<?php

namespace core\classes\simple_crud_helper\DataDB;

use core\classes\interfaces\{
  DataDB\CreateDataDBInterface,
  DataObject\DataObjectInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

class CreateDataDB implements CreateDataDBInterface
{
  /**
   * @var DataObjectInterface $dataObject
   */
  private static $dataObject;

  /**
   * @var QuerySqlStringInterface $querySqlString
   */
  private static $querySqlString;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDB
   */
  private static $repositoryDataDB;

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
