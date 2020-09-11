<?php

namespace src\Interfaces\MVC;

interface ViewInterface
{
  public function createTable(array $dataArray): string;
  public function createPaginatedTbale(array $dataArray): string;
}
