<?php

namespace src\ImplementationObjects\DataDB;

use src\Interfaces\DataDB\FindDataInterface;
use src\Interfaces\QuerySql\QuerySqlStringInterface;
use src\interfaces\Repository\RepositoryDataDBInterface;
use src\interfaces\TableObject\TableInfoInterface;

class FindData implements FindDataInterface
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

  public function find(int $tableIdentifier, array $tableColumns = null): array
  {
    $tableIdentifierName = self::$tableInfoInterface->getTableIdentifier();

    self::$querySqlStringInterface->setSelect($tableColumns);
    self::$querySqlStringInterface->setWhere("{$tableIdentifierName} = :{$tableIdentifierName}");
    self::$repositoryDataDBInterface->setQuery(self::$querySqlStringInterface->getSelect() . self::$querySqlStringInterface->getWhere());

    return self::$repositoryDataDBInterface->recoverData();
  }
}
