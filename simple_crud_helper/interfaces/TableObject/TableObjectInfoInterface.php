<?php

namespace core\classes\interfaces\TableObject;

interface TableObjectInfoInterface
{
  /**
   * @return string
   */
  public function getDataBaseName();
  /**
   * @return void
   */
  public function setDataBaseName(string $dataBaseName);

  /**
   * @return string
   */
  public function getTableName();
  /**
   * @return void
   */
  public function setTableName(string $tableName);

  /**
   * @return string
   */
  public function getTableIdentifier();
  /**
   * @return void
   */
  public function setTableIdentifier(string $tableIdentifier = null);

  /**
   * @return array
   */
  public function getTableColumns();
  /**
   * @return void
   */
  public function setTableColumns(array $tableColumns);

  /**
   * @return array
   */
  public function getTableColumnsDate();
  /**
   * @return void
   */
  public function setTableColumnsDate(array $tableColumnsDate = array());
}
