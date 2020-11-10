<?php

namespace src\interfaces\repository;

use src\interfaces\{
  Helpers\SetDataHelper,
  Audit\AuditInterface,
  Connections\DataBaseConnectionInterface
};

interface RepositoryDataDBInterface extends SetDataHelper
{
  /**
   * @return self
   */
  public static function config(DataBaseConnectionInterface &$dataBaseConnection, AuditInterface &$audit): self;

  /**
   * @return bool
   */
  public function handleData(): bool;
  /**
   * @return array
   */
  public function recoverData(): array;

  /**
   * @return string
   */
  public function getQuery(): string;
  /**
   * @return void
   */
  public function setQuery(string $query): void;

  /**
   * @return void
   */
  public function clean(): void;
}
