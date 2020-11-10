<?php

namespace core\classes\interfaces\QuerySql;

use core\classes\interfaces\DataObject\DataObjectInterface;
use core\classes\interfaces\TableObject\TableObjectInfoInterface;

interface QuerySqlStringInterface
{
  /**
   * @return self
   */
  public static function config(TableObjectInfoInterface &$tableObjectInfo, DataObjectInterface &$dataObject);

  /**
   * @return string
   */
  public function getSelect();
  /**
   * @return void
   */
  public function setSelect(array $tableColumns = null);

  /**
   * @return string
   */
  public function getSelectPagination();

  /**
   * @return void
   */
  public function setSelectPagination(string $select, int $start, int $end, int $amount);

  /**
   * @return string
   */
  public function getJoin();
  /**
   * @return void
   */
  public function setJoin(string $joinCondition);

  /**
   * @return string
   */
  public function getWhere();
  /**
   * @return void
   */
  public function setWhere(string $whereCondition);

  /**
   * @return string
   */
  public function getGroupBy();
  /**
   * @return void
   */
  public function setGroupBy(array $groupByCondition);

  /**
   * @return string
   */
  public function getOrderBy();
  /**
   * @return void
   */
  public function setOrderBy(array $orderByCondition, string $typeOrderBy = "ASC");

  /**
   * @return string
   */
  public function getInsert();
  /**
   * @return void
   */
  public function setInsert(array $tableColumns = null);

  /**
   * @return string
   */
  public function getUpdate();
  /**
   * @return void
   */
  public function setUpdate(array $tableColumns = null);

  /**
   * @return string
   */
  public function getDelete();
  /**
   * @return void
   */
  public function setDelete();

  /**
   * @return void
   */
  public function clean();

  /**
   * @return array
   */
  public function getTableColumnsData();

  /**
   * @return void
   */
  public function setTableColumnsData(array $tableColumnsData);
}
