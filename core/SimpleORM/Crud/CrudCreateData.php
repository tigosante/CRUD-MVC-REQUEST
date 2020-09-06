<?php

namespace core\SimpleORM\Crud;

use core\Interfaces\{
  Crud\CrudCreateDataInterface,
  QueryString\QueryStringInterface,
  Repository\RepositoryHandlerDataInterface
};

class CrudCreateData implements CrudCreateDataInterface
{
  /**
   * @var QueryStringInterface $queryStringInterface
   */
  private $queryStringInterface;

  /**
   * @var RepositoryHandlerDataInterface $repositoryHandlerDataInterface
   */
  private $repositoryHandlerDataInterface;

  public function __construct(QueryStringInterface $queryStringInterface, RepositoryHandlerDataInterface $repositoryHandlerDataInterface)
  {
    $this->queryStringInterface = $queryStringInterface;
    $this->repositoryHandlerDataInterface = $repositoryHandlerDataInterface;
  }

  public function create(array $tableColumns = null): bool
  {
    $this->repositoryHandlerDataInterface->setQuery($this->queryStringInterface->insert($tableColumns));
    return $this->repositoryHandlerDataInterface->handleData();
  }

  public function setData(array $data): void
  {
    $this->repositoryHandlerDataInterface->setData($data);
  }
}
