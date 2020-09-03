<?php

namespace core\interfaces\Repository;

use core\Interfaces\Connections\DataBaseConnectionInterface;

interface RepositoryGetDataInterface
{
  public function __construct(DataBaseConnectionInterface $dataBaseConnectionInterface);

  public function getDataFromDB(): array;

  public function getQuery(): ?string;
  public function setQuery(string $query): void;

  public function getData(): ?array;
  public function setData(array $data = null): void;
}
