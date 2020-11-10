<?php

namespace src\core\pagination;

use src\interfaces\{
  QuerySql\QuerySqlInterface,
  DataDB\FindAllDataInterface,
  Pagination\PaginationInterface,
  QuerySql\QuerySqlStringInterface
};

class Pagination implements PaginationInterface
{
  // TODO: arrumar PAGINATION_END para conter o quantidade final
  private const PAGINATION_END = 15;
  private const PAGINATION_START = 0;
  private const PAGINATION_AMOUNT = 15;

  public const PAGINATION_OPTION_1 = 10;
  public const PAGINATION_OPTION_2 = 20;
  public const PAGINATION_OPTION_3 = 30;

  private array $data;
  private int $paginationEnd = self::PAGINATION_END;
  private int $paginationInit = self::PAGINATION_START;
  private int $paginationAmount = self::PAGINATION_AMOUNT;

  private static QuerySqlInterface $querySql;
  private static FindAllDataInterface $findAllData;
  private static QuerySqlStringInterface $querySqlString;

  public static function config(QuerySqlInterface &$querySql, FindAllDataInterface &$findAllData, QuerySqlStringInterface &$querySqlString): self
  {
    self::$querySql = $querySql;
    self::$findAllData = $findAllData;
    self::$querySqlString = $querySqlString;

    return new self;
  }

  public function init(int $paginationInit = null): self
  {
    $this->paginationInit = $paginationInit !== null ? $paginationInit : self::PAGINATION_START;
    return $this;
  }

  public function amount(int $paginationAmount = null): self
  {
    $this->paginationAmount = $paginationAmount !== null ? $paginationAmount : self::PAGINATION_AMOUNT;
    return $this;
  }

  public function end(int $paginationEnd = null): self
  {
    $this->paginationEnd = $paginationEnd !== null ? $paginationEnd : self::PAGINATION_END;

    return $this;
  }

  public function findAll(array $tableColumns = null): array
  {
    self::$querySqlString->setSelect($tableColumns);
    self::$querySqlString->setSelectPagination(
      self::$querySqlString->getSelect(),
      $this->paginationInit,
      $this->paginationEnd,
      $this->paginationAmount
    );

    return self::$findAllData->findAll();
  }

  public function select(array $tableColumns = null): QuerySqlInterface
  {
    return self::$querySql->select($tableColumns);
  }

  public function where(string $condition): FindAllDataInterface
  {
    return self::$findAllData;
  }

  /**
   * @return array
   */
  public function getData(): array
  {
    return $this->data;
  }

  /**
   * @return void
   */
  public function setData(array $data): void
  {
    $this->data = $data;
  }
}
