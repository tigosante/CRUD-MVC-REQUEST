<?php

namespace src\interfaces\Helpers;

interface SetDataHelper
{
  public function getData(): array;
  public function setData(array $data): void;
}
