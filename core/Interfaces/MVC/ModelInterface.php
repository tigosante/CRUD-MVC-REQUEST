<?php

namespace core\Interfaces\MVC;

use core\Interfaces\Connections\DataBaseConnectionInterface;

interface ModelInterface
{
  public function __construct(DataBaseConnectionInterface $dataBaseConnectionInterface = null);
}
