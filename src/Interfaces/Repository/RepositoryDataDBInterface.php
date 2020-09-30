<?php

namespace src\interfaces\Repository;

use src\Interfaces\{
  Helpers\SetDataHelper,
  Connections\DataBaseConnectionInterface
};

interface RepositoryDataDBInterface extends SetDataHelper
{
  public function __construct(DataBaseConnectionInterface &$dataBaseConnectionInterface);

  public function handleData(): bool;
  public function recoverData(): ?array;

  public function getQuery(): ?string;
  public function setQuery(string $query): void;

  public function clean(): void;
}
