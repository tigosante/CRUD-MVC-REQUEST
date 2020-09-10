<?php

namespace core\interfaces\Repository;

use core\Interfaces\{
  Helpers\SetDataHelper,
  Connections\DataBaseConnectionInterface
};

interface RepositoryDataDBInterface extends SetDataHelper
{
  public function __construct(DataBaseConnectionInterface &$dataBaseConnectionInterface);

  public function getDataDB(): ?array;
  public function handleDataDB(): bool;

  public function getQuery(): ?string;
  public function setQuery(string $query): void;

  public function clean(): void;
}
