<?php

namespace core\classes\interfaces\Connections;

interface DataBaseConnectionInterface
{
  /**
   * @return self
   */
  public static function singleton();

  /**
   * @return \PDO
   */
  public function getConnection();

  /**
   * @return bool
   */
  public function createConnection();
}
