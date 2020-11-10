<?php

namespace core\classes\interfaces\Repository;

use core\classes\interfaces\{
  Helpers\SetDataHelper,
  Audit\AuditInterface,
  Connections\DataBaseConnectionInterface
};

interface RepositoryDataDBInterface extends SetDataHelper
{
  /**
   * @return self
   */
  public static function config(DataBaseConnectionInterface &$dataBaseConnection, AuditInterface &$audit);

  /**
   * @return bool
   */
  public function handleData();
  /**
   * @return array
   */
  public function recoverData();

  /**
   * @return string
   */
  public function getQuery();
  /**
   * @return void
   */
  public function setQuery(string $query);

  /**
   * @return void
   */
  public function clean();
}
