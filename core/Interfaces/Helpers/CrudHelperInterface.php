<?php

namespace core\interfaces\Helpers;

interface CrudHelperInterface
{
  public function Select(): string;
  public function setSelect(string $querySelect): void;

  public function Join(): string;
  public function setJoin(string $joinCondition): void;

  public function Where(): string;
  public function setWhere(string $whereCondition): void;

  public function GroupBy(): string;
  public function setGroupBy(string $groupByCondition): string;

  public function OrderBy(): string;
  public function setOrderBy(string $orderByCondition): string;
}
