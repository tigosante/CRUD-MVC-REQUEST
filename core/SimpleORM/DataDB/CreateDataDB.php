<?php

namespace core\SimpleORM\DataDB;

use core\interfaces\{
  DataDB\CreateDataDBInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

/**
 * @method __construct(QuerySqlStringInterface $querySqlStringInterface, RepositoryDataDBInterface $repositoryDataDBInterface)
 * @method create(array $tableColumns = null): bool
 * @method getData(): ?array
 * @method setData(array $data): void
 */
class CreateDataDB implements CreateDataDBInterface
{
  /**
   * @var array $data
   */
  private $data;

  /**
   * @var QuerySqlStringInterface $querySqlStringInterface
   */
  private $querySqlStringInterface;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDBInterface
   */
  private $repositoryDataDBInterface;

  public function __construct(QuerySqlStringInterface $querySqlStringInterface, RepositoryDataDBInterface $repositoryDataDBInterface)
  {
    $this->querySqlStringInterface = $querySqlStringInterface;
    $this->repositoryDataDBInterface = $repositoryDataDBInterface;
  }

  public function create(array $tableColumns = null): bool
  {
    $this->querySqlStringInterface->setInsert($tableColumns);
    $this->repositoryDataDBInterface->setQuery($this->querySqlStringInterface->getInsert());
    $this->repositoryDataDBInterface->setData($this->getData());

    return $this->repositoryDataDBInterface->handleDataDB();
  }

  public function getData(): ?array
  {
    return $this->data;
  }

  public function setData(array $data): void
  {
    $this->data = $data;
  }
}
