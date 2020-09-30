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
  private $tableInfoInterface;

  /**
   * @var QuerySqlStringInterface $querySqlStringInterface
   */
  private $querySqlStringInterface;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDBInterface
   */
  private $repositoryDataDBInterface;

  public function __construct(QuerySqlStringInterface &$querySqlStringInterface, TableInfoInterface &$tableInfoInterface, RepositoryDataDBInterface &$repositoryDataDBInterface)
  {
    $this->tableInfoInterface = $tableInfoInterface;
    $this->querySqlStringInterface = $querySqlStringInterface;
    $this->repositoryDataDBInterface = $repositoryDataDBInterface;
  }

  public function find(int $tableIdentifier, array $tableColumns = null): array
  {
    $tableIdentifierName = $this->tableInfoInterface->getTableIdentifier();

    $this->querySqlStringInterface->setSelect($tableColumns);
    $this->querySqlStringInterface->setWhere("{$tableIdentifierName} = :{$tableIdentifierName}");
    $this->repositoryDataDBInterface->setQuery($this->querySqlStringInterface->getSelect() . $this->querySqlStringInterface->getWhere());

    return $this->repositoryDataDBInterface->recoverData();
  }
}
