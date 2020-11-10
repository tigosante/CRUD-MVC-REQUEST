<?php

namespace src\interfaces\table;

use src\interfaces\{
  DataDB\DataDBInterface,
  QuerySql\QuerySqlInterface,
  Pagination\PaginationInterface,
};

interface TableObjectInterface
{
  /**
   * @return void
   */
  public function config(object &$object, array $tableConfiguration): void;

  /**
   * @param bool $useRequest = true
   *
   * @return void
   */
  public function useRequest(bool $useRequest = true): void;

  /**
   * @return array
   */
  public function getAllData(bool $useREQUEST = true): array;

  /**
   * @return bool
   */
  public function setAllData(array $data = null, bool $useRequest = true): bool;

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

  /**
   * @return bool
   */
  public function create(array $tableColumns = null): bool;

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
   * @return self
   */
  public function audit(int $cd_evento, string $ds_complemento): self;

  /**
   * @return self
   */
  public function isMakeAudit(bool $isMakeAudit = true): self;

  /**
   * @return string
   */
  public function queryString(string $typeQuery = null): string;

  /**
   * @return void
   */
  public function clean(): void;
}
