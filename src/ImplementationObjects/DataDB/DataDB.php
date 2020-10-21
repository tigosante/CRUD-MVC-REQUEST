<?php

namespace src\ImplementationObjects\DataDB;

use src\Interfaces\{
  DataDB\DataDBInterface,
  DataObject\DataObjectInterface,
  TableObject\TableInfoInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface,
};

class DataDB implements DataDBInterface
{
  /**
   * @var DataObjectInterface $dataObject
   */
  private static $dataObject;

  /**
   * @var TableInfoInterface $tableInfo
   */
  private static $tableInfo;

  /**
   * @var QuerySqlStringInterface $querySqlString
   */
  private static $querySqlString;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDB
   */
  private static $repositoryDataDB;

  public static function config(DataObjectInterface $dataObject, QuerySqlStringInterface &$querySqlString, TableInfoInterface &$tableInfo, RepositoryDataDBInterface &$repositoryDataDB): self
  {
    self::$tableInfo = $tableInfo;
    self::$dataObject = $dataObject;
    self::$querySqlString = $querySqlString;
    self::$repositoryDataDB = $repositoryDataDB;

    return new self;
  }

  public function findAll(array $tableColumns = null): array
  {
    self::$querySqlString->setSelect($tableColumns);
    self::$repositoryDataDB->setQuery(self::$querySqlString->getSelect() . self::$querySqlString->getWhere());

    return self::$repositoryDataDB->recoverData();
  }

  public function delete(int $tableIdentifier): bool
  {
    $tableIdentifierName = self::$tableInfo->getTableIdentifier();

    self::$querySqlString->setDelete();
    self::$querySqlString->setWhere("{$tableIdentifierName} = :{$tableIdentifierName}");
    self::$repositoryDataDB->setData([$tableIdentifierName => $tableIdentifier]);

    self::$repositoryDataDB->setQuery(self::$querySqlString->getDelete() . self::$querySqlString->getWhere());

    return self::$repositoryDataDB->handleData();
  }

  public function update(array $tableColumns = null): bool
  {
    self::$querySqlString->setUpdate($tableColumns);

    $tableColumns = empty($tableColumns) ? self::$querySqlString->getTableColumnsData() : $tableColumns;

    self::$repositoryDataDB->setData(self::$dataObject->getData($tableColumns));
    self::$repositoryDataDB->setQuery(self::$querySqlString->getUpdate() . self::$querySqlString->getWhere());

    return self::$repositoryDataDB->handleData();
  }

  public function where(string $conditions): self
  {
    self::$querySqlString->setWhere($conditions);
    return $this;
  }

  public function getData(): array
  {
    return self::$repositoryDataDB->getData();
  }

  public function setData(array $data): void
  {
    self::$repositoryDataDB->setData($data);
  }
}
