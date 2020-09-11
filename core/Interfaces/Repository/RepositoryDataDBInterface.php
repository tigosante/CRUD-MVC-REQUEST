<?php

namespace core\interfaces\Repository;

use core\Interfaces\{
  Helpers\SetDataHelper,
  DataDB\Fetch\Fetch,
  Connections\DataBaseConnectionInterface
};

interface RepositoryDataDBInterface extends Fetch, SetDataHelper
{
  public function __construct(DataBaseConnectionInterface &$dataBaseConnectionInterface);

  public function getDataDB(): ?array;
  public function handleDataDB(): bool;

  public function getQuery(): ?string;
  public function setQuery(string $query): void;

  public function clean(): void;
}
