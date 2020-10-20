<?php

namespace src\ImplementationObjects\Audit;

use src\Interfaces\Audit\AuditInterface;

class Audit implements AuditInterface
{
  /**
   * @var object $objectAudit
   */
  private $objectAudit;

  /**
   * @var bool $isMakeAudit
   */
  private $isMakeAudit = false;

  /**
   * @var array $data
   */
  private $data = array();


  public function __construct(object $objectAudit)
  {
    $this->objectAudit = $objectAudit;
  }

  /**
   * @return string
   */
  public function getQueryAudit(): string
  {
    return $this->objectAudit->queryString("create");
  }

  /**
   * @return bool
   */
  public function isMakeAudit(): bool
  {
    return $this->isMakeAudit;
  }

  /**
   * @return void
   */
  public function makeAudit(bool $isMakeAudit): void
  {
    $this->isMakeAudit = $isMakeAudit;
  }

  /**
   * @return bool
   */
  public function createAuditInDB(\PDO &$connection): bool
  {
    return $connection->prepare($this->getQueryAudit())->execute($this->getData);
  }

  public function getData(): array
  {
    return $this->data;
  }

  public function setData(array $data): void
  {
    $this->data = $data;
  }
}
