<?php

namespace src\interfaces\audit;

use src\interfaces\Helpers\SetDataHelper;

interface AuditInterface extends SetDataHelper
{
  /**
   * @return self
   */
  public function config(AuditObjectInterface &$objectAudit): self;

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
  public function notify(bool $isMakeAudit): void;

  /**
   * @return bool
   */
  public function createAuditInDB(\PDO &$connection): bool;

  /**
   * @return string
   */
  public function recoveryIpMachine(): string;
}
