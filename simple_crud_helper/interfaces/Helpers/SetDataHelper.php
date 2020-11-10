<?php

namespace core\classes\interfaces\Helpers;

interface SetDataHelper
{
  /**
   * @return array
   */
  public function getData();
  /**
   * @return void
   */
  public function setData(array $data);
}
