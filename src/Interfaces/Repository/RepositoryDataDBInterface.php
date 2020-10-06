<?php

namespace src\interfaces\Repository;

use src\Interfaces\{
  Helpers\SetDataHelper,
  Connections\DataBaseConnectionInterface
};
use src\Interfaces\Audit\AuditInterface;

interface RepositoryDataDBInterface extends SetDataHelper
{
  public function __construct(DataBaseConnectionInterface &$dataBaseConnectionInterface, AuditInterface &$auditInterface);

  public function handleData(): bool;
  public function recoverData(): array;

  public function getQuery(): string;
  public function setQuery(string $query): void;

  public function clean(): void;
}
