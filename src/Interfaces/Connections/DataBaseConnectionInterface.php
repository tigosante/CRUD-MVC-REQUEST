<?php

namespace src\Interfaces\Connections;

interface DataBaseConnectionInterface
{
  public static function singleton(): self;
  public function getConnection(): \PDO;
}
