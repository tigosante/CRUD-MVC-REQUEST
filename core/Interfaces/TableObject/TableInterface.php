<?php

namespace core\interfaces\TableObject;

use core\Interfaces\DataDB\DataDBInterface;
use core\Interfaces\QuerySql\QuerySqlInterface;

/**
 * @method function __construct(array $tableConfig, object $object);
 * @method function setAllData(bool $isDataToTableDataBase = true): bool;
 * @method function setDataFromArray(array $dataArray, bool $isDataToTableDataBase = true): bool;
 * @method function select(array $tableColumns = null): QuerySqlInterface;
 * @method function where(string $conditions): DataDBInterface;
 * @method function create(array $tableColumns = null): bool;
 * @method function find(int $tableIdentifier, array $tableColumns = null): array;
 * @method function findAll(array $tableColumns = null): array;
 * @method function setData(array $data): void;
 * @method function clean(): void;
 */
interface TableInterface
{
  public function __construct(array $tableConfig, object $object);

  public function setAllData(bool $isDataToTableDataBase = true): bool;
  public function setDataFromArray(array $dataArray, bool $isDataToTableDataBase = true): bool;
  public function ignoreInArray(array $ignore): void;

  public function select(array $tableColumns = null): QuerySqlInterface;

  public function where(string $conditions): DataDBInterface;

  public function create(array $tableColumns = null): bool;

  public function find(int $tableIdentifier, array $tableColumns = null): array;
  public function findAll(array $tableColumns = null): array;

  public function setData(array $data): void;

  public function clean(): void;
}
