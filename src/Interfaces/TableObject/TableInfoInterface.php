<?php

namespace src\interfaces\TableObject;

interface TableInfoInterface
{
  /**
   * @return string
   */
  public function getDataBaseName(): string;

  /**
   * @return void
   */
  public function setDataBaseName(string $dataBaseName): void;

  /**
   * @return string
   */
  public function getTableName(): string;

  /**
   * @return void
   */
  public function setTableName(string $tableName): void;

  /**
   * @return string
   */
  public function getTableIdentifier(): string;

  /**
   * @return void
   */
  public function setTableIdentifier(string $tableIdentifier = null): void;

  /**
   * @return array
   */
  public function getTableColumns(): array;

  /**
   * @return void
   */
  public function setTableColumns(array $tableColumns): void;

  /**
   * @return array
   */
  public function getTableColumnsDate(): array;

  /**
   * @return void
   */
  public function setTableColumnsDate(array $tableColumnsDate = null): void;
}
