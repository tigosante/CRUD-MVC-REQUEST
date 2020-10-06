<?php

namespace src\Interfaces\Audit;

use src\interfaces\Helpers\SetDataHelper;

interface AuditInterface extends SetDataHelper
{
  public function __construct(object $objectAudit);

  /**
   * @return string
   */
  public function getQueryAudit(): string;

  /**
   * @return bool
   */
  public function isMakeAudit(): bool;

  /**
   * @return void
   */
  public function makeAudit(bool $isMakeAudit): void;

  /**
   * @return bool
   */
  public function createAuditInDB(\PDO &$connection): bool;
}
