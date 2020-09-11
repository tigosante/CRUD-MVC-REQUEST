<?php

namespace src\Interfaces\MVC;

use src\Interfaces\Connections\DataBaseConnectionInterface;

interface ModelInterface
{
  public function __construct(DataBaseConnectionInterface $dataBaseConnectionInterface = null);
}
