<?php

namespace core\Interfaces\Connections;

/**
 * @method singleton(): self;
 * @method getConnection(): \PDO;
 */
interface DataBaseConnectionInterface
{
  public static function singleton(): self;
  public function getConnection(): \PDO;
}
