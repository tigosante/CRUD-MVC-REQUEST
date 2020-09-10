<?php

namespace core\SimpleORM\Pagination;

use core\Interfaces\{
  QuerySql\QuerySqlInterface,
  DataDB\FindAllDataInterface,
  Pagination\PaginationInterface
};

class Pagination implements PaginationInterface
{
  private const PAGINATION_INIT = 0;
  private const PAGINATION_AMOUNT = 15;
  private const PAGINATION_END = 15;

  /**
   * @var int $paginationInit
   */
  private $paginationInit = self::PAGINATION_INIT;

  /**
   * @var int $paginationAmount
   */
  private $paginationAmount = self::PAGINATION_AMOUNT;

  /**
   * @var int $paginationEnd
   */
  private $paginationEnd = self::PAGINATION_END;

  /**
   * @var array $data
   */
  private $data;

  /**
   * @var QuerySqlInterface $querySqlInterface
   */
  private $querySqlInterface;

  /**
   * @var FindAllDataInterface $findAllDataInterface
   */
  private $findAllDataInterface;

  public function __construct(QuerySqlInterface $querySqlInterface, FindAllDataInterface $findAllDataInterface)
  {
    $this->querySqlInterface = $querySqlInterface;
    $this->findAllDataInterface = $findAllDataInterface;
  }

  public function init(int $paginationInit = null): self
  {
    $this->paginationInit = $paginationInit !== null ? $paginationInit : self::PAGINATION_INIT;
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
    return $this->findAllDataInterface->findAll($tableColumns);
  }

  public function select(array $tableColumns = null): QuerySqlInterface
  {
    return $this->querySqlInterface->select($tableColumns);
  }

  public function where(string $condition): FindAllDataInterface
  {
    return $this->findAllDataInterface;
  }

  public function getData(): ?array
  {
    return $this->querySqlInterface->getData();
  }

  public function setData(array $data): void
  {
    $this->querySqlInterface->setData($data);
  }
}
