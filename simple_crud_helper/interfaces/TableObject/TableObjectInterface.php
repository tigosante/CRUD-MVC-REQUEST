<?php

namespace core\classes\interfaces\TableObject;

use core\classes\interfaces\{
  DataDB\DataDBInterface,
  QuerySql\QuerySqlInterface,
  Pagination\PaginationInterface,
};

interface TableObjectInterface
{
  /**
   * @return void
   */
  public function config(object &$object, array $tableConfiguration);

  /**
   * @param bool $useRequest = true
   *
   * @return void
   */
  public function useRequest(bool $useRequest = true);

  /**
   * @return array
   */
  public function getAllData(bool $useREQUEST = true);

  /**
   * @return bool
   */
  public function setAllData(array $data = null, bool $useRequest = true);

  /**
   * @return void
   */
  public function ignoreViewField(array $ignore, bool $isAddInArray = false);

  /**
   * @return void
   */
  public function resetIgnoreViewField();

  /**
   * @return QuerySqlInterface
   */
  public function select(array $tableColumns = null);

  /**
   * @return DataDBInterface
   */
  public function where(string $conditions);

  /**
   * @return bool
   */
  public function create(array $tableColumns = null);

  /**
   * @return array
   */
  public function find(int $tableIdentifier, array $tableColumns = null);

  /**
   * @return array
   */
  public function findAll(array $tableColumns = null);

  /**
   * @return PaginationInterface
   */
  public function pagination(int $paginationInit = null, int $paginationAmount = null, int $paginationEnd = null);

  /**
   * @return self
   */
  public function audit(int $cd_evento, string $ds_complemento);

  /**
   * @return self
   */
  public function isMakeAudit(bool $isMakeAudit = true);

  /**
   * @return string
   */
  public function queryString(string $typeQuery = null);

  /**
   * @return void
   */
  public function clean();
}
