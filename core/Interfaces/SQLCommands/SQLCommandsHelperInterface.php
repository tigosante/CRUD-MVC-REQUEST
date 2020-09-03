<?php

namespace core\interfaces\SQLCommands;

use core\interfaces\TableObject\TableObjectHelperInterface;

interface SQLCommandsHelperInterface
{
  public function __construct(TableObjectHelperInterface $tableObjectHelperInterface);

  public function getSelect(): string;
  public function setSelect(array $tableColumns = null): void;

  public function getJoin(): string;
  public function setJoin(string $joinCondition): void;

  public function getWhere(): string;
  public function setWhere(array $whereCondition): void;

  public function getGroupBy(): string;
  public function setGroupBy(array $groupByCondition): void;

  public function getOrderBy(): string;
  public function setOrderBy(array $orderByCondition): void;

  public function clean(): void;
}
