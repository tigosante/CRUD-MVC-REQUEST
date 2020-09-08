<?php

namespace core\interfaces\Helpers;

interface SetDataHelper
{
  public function getData(): ?array;
  public function setData(array $data): void;
}
