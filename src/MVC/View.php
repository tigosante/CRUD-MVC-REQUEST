<?php

namespace src\MVC;

use src\Interfaces\MVC\ViewInterface;

class View implements ViewInterface
{
  public function createTable(array $dataArray): string
  {
    return "";
  }

  public function createPaginatedTbale(array $dataArray): string
  {
    return "";
  }
}
