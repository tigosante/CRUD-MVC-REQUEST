<?php

namespace core\interfaces\Helpers;

interface CrudHelperInterface
{
  public function getSelect(): string;
  public function setSelect(string $querySelect): void;

  public function getJoin(): string;
  public function setJoin(string $joinCondition): void;

  public function getWhere(): string;
  public function setWhere(string $whereCondition): void;

  public function getGroupBy(): string;
  public function setGroupBy(string $groupByCondition): string;

  public function getOrderBy(): string;
  public function setOrderBy(string $orderByCondition): string;
}
