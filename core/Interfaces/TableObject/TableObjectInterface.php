<?php

namespace core\interfaces\TableObject;

use core\interfaces\Crud\CrudHandlerDataInterface;
use core\interfaces\SQLCommands\SQLCommandsInterface;

interface TableObjectInterface
{
  public function __construct(array $tableConfig, object $object);

  public function setAllData(bool $isDataToTableDataBase = true): bool;
  public function setAllDataFromArray(array $dataArray, bool $isDataToTableDataBase = true): bool;

  public function select(array $tableColumns = null): SQLCommandsInterface;

  public function where(string $conditions): CrudHandlerDataInterface;

  public function create(array $tableColumns = null): bool;

  public function findAll(array $tableColumns = null): array;
  public function findBySq(int $tableSq, array $tableColumns = null): array;

  public function setData(array $data): void;
}
