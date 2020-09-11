<?php

namespace src\ImplementationObjects\DataDB;

use src\Interfaces\DataDB\FindAllDataInterface;
use src\Interfaces\QuerySql\QuerySqlStringInterface;
use src\interfaces\Repository\RepositoryDataDBInterface;

class FindAllData implements FindAllDataInterface
{
  /**
   * @var QuerySqlStringInterface $querySqlStringInterface
   */
  private $querySqlStringInterface;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDBInterface
   */
  private $repositoryDataDBInterface;

  public function __construct(QuerySqlStringInterface &$querySqlStringInterface, RepositoryDataDBInterface &$repositoryDataDBInterface)
  {
    $this->querySqlStringInterface = $querySqlStringInterface;
    $this->repositoryDataDBInterface = $repositoryDataDBInterface;
  }

  public function findAll(array $tableColumns = null): array
  {
    $this->querySqlStringInterface->setSelect($tableColumns);
    $this->repositoryDataDBInterface->setQuery($this->querySqlStringInterface->getSelect());

    return $this->repositoryDataDBInterface->getDataDB();
  }
}
