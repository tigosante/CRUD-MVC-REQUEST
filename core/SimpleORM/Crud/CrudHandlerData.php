<?php

namespace core\SimpleORM\Crud;

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

  /**
   * @var string $conditions
   */
  private $conditions = " WHERE 1=1 ";

  public function __construct(QueryStringInterface $queryStringInterface, RepositoryHandlerDataInterface $repositoryHandlerDataInterface)
  {
    $this->queryStringInterface = $queryStringInterface;
    $this->repositoryHandlerDataInterface = $repositoryHandlerDataInterface;
  }

  public function where(string $conditions): self
  {
    $this->conditions .= " {$conditions} ";
    return $this;
  }

  public function update(array $tableColumns = null): bool
  {
    $this->repositoryHandlerDataInterface->setQuery($this->queryFactory("update", $tableColumns) . $this->conditions);
    return $this->repositoryHandlerDataInterface->handleData();
  }

  public function delete(int $tableSq): bool
  {
    $this->repositoryHandlerDataInterface->setQuery($this->queryFactory("delete") . $this->conditions);
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
