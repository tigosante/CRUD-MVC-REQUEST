<?php

namespace core\interfaces\Helpers;

/**
 * @method getData(): ?array
 * @method setData(array $data): void
 */
interface SetDataHelper
{
  public function getData(): ?array;
  public function setData(array $data): void;
}
