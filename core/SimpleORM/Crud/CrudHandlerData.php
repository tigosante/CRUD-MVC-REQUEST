<?php

namespace core\interfaces\Crud;

use core\interfaces\{
  Crud\CrudHandlerDataInterface,
  QueryString\QueryStringInterface,
  Repository\RepositoryHandlerDataInterface
};

class CrudHandlerData implements CrudHandlerDataInterface
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

  public function update(array $tableColumns = null): bool
  {
    $this->repositoryHandlerDataInterface->setQuery($this->queryFactory("update", $tableColumns));
    return $this->repositoryHandlerDataInterface->handleData();
  }

  public function delete(int $tableSq): bool
  {
    $this->repositoryHandlerDataInterface->setQuery($this->queryFactory("delete"));
    return $this->repositoryHandlerDataInterface->handleData();
  }

  public function setData(array $data): void
  {
    $this->repositoryHandlerDataInterface->setData($data);
  }

  private function queryFactory(string $queryTpe, array $tableColumns = null): string
  {
    return $queryTpe === "delete" ? $this->queryStringInterface->delete() : $this->queryStringInterface->update($tableColumns);
  }
}
