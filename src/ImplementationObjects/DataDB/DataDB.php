<?php

namespace src\ImplementationObjects\DataDB;

use src\Interfaces\{
  DataDB\DataDBInterface,
  TableObject\TableInfoInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

class DataDB implements DataDBInterface
{
  /**
   * @var TableInfoInterface $tableInfoInterface
   */
  private static $tableInfoInterface;

  /**
   * @var QuerySqlStringInterface $querySqlStringInterface
   */
  private static $querySqlStringInterface;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDBInterface
   */
  private static $repositoryDataDBInterface;

  public static function config(QuerySqlStringInterface &$querySqlStringInterface, TableInfoInterface &$tableInfoInterface, RepositoryDataDBInterface &$repositoryDataDBInterface): self
  {
    self::$tableInfoInterface = $tableInfoInterface;
    self::$querySqlStringInterface = $querySqlStringInterface;
    self::$repositoryDataDBInterface = $repositoryDataDBInterface;

    return new self;
  }

  public function findAll(array $tableColumns = null): array
  {
    self::$querySqlStringInterface->setSelect($tableColumns);
    self::$repositoryDataDBInterface->setQuery(self::$querySqlStringInterface->getSelect() . self::$querySqlStringInterface->getWhere());

    return self::$repositoryDataDBInterface->recoverData();
  }

  public function delete(int $tableIdentifier): bool
  {
    $tableIdentifierName = self::$tableInfoInterface->getTableIdentifier();

    self::$querySqlStringInterface->setDelete();
    self::$querySqlStringInterface->setWhere("{$tableIdentifierName} = :{$tableIdentifierName}");
    self::$repositoryDataDBInterface->setData([$tableIdentifierName => $tableIdentifier]);

    self::$repositoryDataDBInterface->setQuery(self::$querySqlStringInterface->getDelete() . self::$querySqlStringInterface->getWhere());

    return self::$repositoryDataDBInterface->handleData();
  }

  public function update(array $tableColumns = null): bool
  {
    self::$querySqlStringInterface->setUpdate($tableColumns);
    self::$repositoryDataDBInterface->setQuery(self::$querySqlStringInterface->getUpdate() . self::$querySqlStringInterface->getWhere());

    return self::$repositoryDataDBInterface->handleData();
  }

  public function where(string $conditions): self
  {
    self::$querySqlStringInterface->setWhere($conditions);
    return $this;
  }

  public function getData(): array
  {
    return self::$repositoryDataDBInterface->getData();
  }

  public function setData(array $data): void
  {
    self::$repositoryDataDBInterface->setData($data);
  }
}
