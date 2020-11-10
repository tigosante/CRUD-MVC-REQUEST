<?php

namespace src\interfaces\dataObject;

interface DataObjectInterface
{
  /**
   * @return self
   */
  public static function config(object &$object): self;

  /**
   * @return array
   */
  public function getData(array $columns): array;
}
