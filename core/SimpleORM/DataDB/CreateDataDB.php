<?php

namespace core\SimpleORM\DataDB;

use core\interfaces\{
  DataDB\CreateDataDBInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

class CreateDataDB implements CreateDataDBInterface
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

  public function create(array $tableColumns = null): bool
  {
    $this->querySqlStringInterface->setInsert($tableColumns);
    $this->repositoryDataDBInterface->setQuery($this->querySqlStringInterface->getInsert());

    return $this->repositoryDataDBInterface->handleDataDB();
  }
}
