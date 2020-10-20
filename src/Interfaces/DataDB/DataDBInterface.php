<?php

namespace src\Interfaces\DataDB;

use src\interfaces\{
  Helpers\SetDataHelper,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface,
  TableObject\TableInfoInterface
};

interface DataDBInterface extends SetDataHelper
{
  /**
   * @return self
   */
  public static function config(QuerySqlStringInterface &$querySqlStringInterface, TableInfoInterface &$tableInfoInterface, RepositoryDataDBInterface &$repositoryDataDBInterface): self;

  /**
   * @return bool
   */
  public function delete(int $tableIdentifier): bool;

  /**
   * @return bool
   */
  public function update(array $tableColumns = null): bool;

  /**
   * @return array
   */
  public function findAll(array $tableColumns = null): array;

  /**
   * @return self
   */
  public function where(string $conditions): self;
}
