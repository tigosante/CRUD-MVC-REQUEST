<?php

namespace src\Interfaces\QuerySql;

use src\interfaces\Helpers\{
  QueryDataHelper,
  SetDataHelper
};

interface QuerySqlInterface extends QueryDataHelper, SetDataHelper
{
  /**
   * @return self
   */
  public function select(array $tableColumns = null): self;

  /**
   * @return self
   */
  public function join(string $joinCondition): self;

  /**
   * @return self
   */
  public function where(array $whereCondition): self;

  /**
   * @return self
   */
  public function groupBy(array $groupByCondition): self;

  /**
   * @return self
   */
  public function orderBy(array $orderByCondition, string $type = "ASC"): self;

  /**
   * @return void
   */
  public function clean(): void;

  /**
   * @return array
   */
  public function fetchAll(): array;

  /**
   * @return string
   */
  public function queryString(): string;
}
