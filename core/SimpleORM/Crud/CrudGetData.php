<?php

namespace core\interfaces\Crud;

use core\interfaces\{
  Crud\CrudGetDataInterface,
  QueryString\QueryStringInterface,
  Repository\RepositoryGetDataInterface
};

class CrudGetData implements CrudGetDataInterface
{
  /**
   * @var QueryStringInterface $queryStringInterface
   */
  private $queryStringInterface;

  /**
   * @var RepositoryGetDataInterface $repositoryGetDataInterface
   */
  private $repositoryGetDataInterface;

  public function __construct(QueryStringInterface $queryStringInterface, RepositoryGetDataInterface $repositoryGetDataInterface)
  {
    $this->queryStringInterface = $queryStringInterface;
    $this->repositoryGetDataInterface = $repositoryGetDataInterface;
  }

  public function findAll(array $tableColumns = null): array
  {
    $this->repositoryGetDataInterface->setQuery($this->queryStringInterface->select($tableColumns));
    return $this->repositoryGetDataInterface->getDataFromDB();
  }

  public function findBySq(int $tableSq, array $tableColumns = null): array
  {
    $query = $this->queryStringInterface->select($tableColumns) . $this->queryStringInterface->where(" = {$tableSq}", true);
    $this->repositoryGetDataInterface->setQuery($query);

    return $this->repositoryGetDataInterface->getDataFromDB();
  }

  public function setData(array $data): void
  {
    $this->repositoryHandlerDataInterface->setData($data);
  }
}
