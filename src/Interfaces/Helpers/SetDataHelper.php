<?php

namespace src\interfaces\helpers;

interface SetDataHelper
{
  /**
   * @return array
   */
  public function getData(): array;

  /**
   * @return void
   */
  public function setData(array $data): void;
}
