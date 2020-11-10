<?php

namespace core\classes\interfaces\DataObject;

interface DataObjectInterface
{
  /**
   * @return self
   */
  public static function config(object &$object);

  /**
   * @return array
   */
  public function getData(array $columns);
}
