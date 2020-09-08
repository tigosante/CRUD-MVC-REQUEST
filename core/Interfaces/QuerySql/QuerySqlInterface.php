<?php

namespace core\Interfaces\QuerySql;

use core\interfaces\Helpers\{
  SetDataHelper,
  QueryDataHelper
};

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
