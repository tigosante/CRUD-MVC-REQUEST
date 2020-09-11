<?php

namespace core\Interfaces\MVC;

interface ViewInterface
{
  public function createTable(array $dataArray): string;
  public function createPaginatedTbale(array $dataArray): string;
}
