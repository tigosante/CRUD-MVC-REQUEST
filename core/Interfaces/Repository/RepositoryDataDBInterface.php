<?php

namespace core\interfaces\Repository;

use core\Interfaces\Connections\DataBaseConnectionInterface;

interface RepositoryDataDBInterface
{
  public function __construct(DataBaseConnectionInterface $dataBaseConnectionInterface);

  public function getDataDB(): ?array;
  public function handleDataDB(): bool;

  public function getQuery(): ?string;
  public function setQuery(string $query): void;

  public function getData(): ?array;
  public function setData(array $query): void;
}
