<?php

namespace core\Interfaces\QuerySql;

use core\interfaces\Helpers\{
  QueryDataHelper,
  SetDataHelper
};

/**
 * @method select(array $tableColumns = null): self;
 * @method join(string $joinCondition): self;
 * @method where(array $whereCondition): self;
 * @method groupBy(array $groupByCondition): self;
 * @method orderBy(array $orderByCondition): self;
 * @method clean(): void;
 * @method fetchAll(): array;
 * @method getQueryString(): string;
 */
interface QuerySqlInterface extends QueryDataHelper, SetDataHelper
{
  public function select(array $tableColumns = null): self;
  public function join(string $joinCondition): self;
  public function where(array $whereCondition): self;
  public function groupBy(array $groupByCondition): self;
  public function orderBy(array $orderByCondition): self;

  public function clean(): void;
  public function fetchAll(): array;
  public function getQueryString(): string;
}
