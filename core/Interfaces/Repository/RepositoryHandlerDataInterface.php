<?php

namespace core\interfaces\Repository;

use core\Interfaces\Connections\DataBaseConnectionInterface;

interface RepositoryHandlerDataInterface
{
  public function __construct(DataBaseConnectionInterface $dataBaseConnectionInterface);

  public function handleData(): bool;

  public function getQuery(): ?string;
  public function setQuery(string $query): void;

  public function getData(): ?array;
  public function setData(array $query): void;
}
