<?php

namespace src\Interfaces\QuerySql;

use src\interfaces\Helpers\{
  QueryDataHelper,
  SetDataHelper
};

interface QuerySqlInterface extends QueryDataHelper, SetDataHelper
{
  public function select(array $tableColumns = null): self;
  public function join(string $joinCondition): self;
  public function where(array $whereCondition): self;
  public function groupBy(array $groupByCondition): self;
  public function orderBy(array $orderByCondition, string $type = "ASC"): self;

  public function clean(): void;
  public function fetchAll(): array;
  public function queryString(): string;
}
