<?php

namespace core\interfaces\SQLCommands;

use core\interfaces\SQLCommands\SQLCommandsHelperInterface;


interface SQLCommandsInterface
{
  public function __construct(SQLCommandsHelperInterface $sqlCommandsHelperInterface);

  public function select(array $tableColumns = null): self;
  public function join(string $joinCondition): self;
  public function where(array $whereCondition): self;
  public function groupBy(array $groupByCondition): self;
  public function orderBy(array $orderByCondition): self;

  public function clean(): void;
  public function setdata(array $data = null): self;
  public function getQueryString(): string;

  public function fetchAll(): array;
}
