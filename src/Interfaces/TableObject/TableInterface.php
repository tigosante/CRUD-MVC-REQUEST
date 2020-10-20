<?php

namespace src\interfaces\TableObject;

use src\Interfaces\{
  DataDB\DataDBInterface,
  QuerySql\QuerySqlInterface,
  Pagination\PaginationInterface,
};

interface TableInterface
{
  /**
   * @return void
   */
  public static function config(object &$object, array $tableConfiguration): void;

  /**
   * @return array
   */
  public function getAllData(bool $useREQUEST = true): array;

  /**
   * @return bool
   */
  public function setAllData(array $data = null, bool $isDataToTableDataBase = true): bool;

  /**
   * @return void
   */
  public function ignoreViewField(array $ignore, bool $isAddInArray = false): void;

  /**
   * @return void
   */
  public function resetIgnoreViewField(): void;

  /**
   * @return QuerySqlInterface
   */
  public function select(array $tableColumns = null): QuerySqlInterface;

  /**
   * @return DataDBInterface
   */
  public function where(string $conditions): DataDBInterface;

<<<<<<< HEAD
  public function audit(): self;

  public function pagination(int $paginationInit = null, int $paginationAmount = null, int $paginationEnd = null): PaginationInterface;
=======
  /**
   * @return bool
   */
  public function create(array $tableColumns = null): bool;
>>>>>>> master

  /**
   * @return array
   */
  public function find(int $tableIdentifier, array $tableColumns = null): array;

  /**
   * @return array
   */
  public function findAll(array $tableColumns = null): array;

  /**
   * @return PaginationInterface
   */
  public function pagination(int $paginationInit = null, int $paginationAmount = null, int $paginationEnd = null): PaginationInterface;

  /**
   * @return void
   */
  public function clean(): void;
}
