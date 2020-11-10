<?php

namespace src\core\audit;

use src\interfaces\Audit\AuditInterface;
use src\interfaces\Audit\AuditObjectInterface;
use core\classes\UsuarioLogado;

class Audit implements AuditInterface
{
  private AuditObjectInterface $objectAudit;
  private bool $isMakeAudit = false;
  private array $data = array();

  public const CD_CANAL = "CD_CANAL";
  public const CD_EVENTO = "CD_EVENTO";
  public const NR_MATRICULA = "NR_MATRICULA";
  public const DS_IP_MAQUINA = "DS_IP_MAQUINA";
  public const DS_COMPLEMENTO = "DS_COMPLEMENTO";

  public function config(AuditObjectInterface &$objectAudit): self
  {
    $this->objectAudit = $objectAudit;
    return $this;
  }

  /**
   * @return string
   */
  public function getQueryAudit(): string
  {
    return $this->objectAudit->getQuery();
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
  public function notify(bool $isMakeAudit): void
  {
    $this->isMakeAudit = $isMakeAudit;
  }

  /**
   * @return bool
   */
  public function createAuditInDB(\PDO &$connection): bool
  {
    return $this->objectAudit->create($connection);
  }

  /**
   * @return array
   */
  public function getData(): array
  {
    return $this->data;
  }

  /**
   * @return void
   */
  public function setData(array $data): void
  {
    $this->data[":" . self::CD_CANAL] = $this->objectAudit->get_cd_canal();
    $this->data[":" . self::DS_IP_MAQUINA] = $this->recoveryIpMachine();

    $this->data[":" . self::CD_EVENTO] = $data[self::CD_EVENTO];
    $this->data[":" . self::NR_MATRICULA] = UsuarioLogado::getInstance()->nr_matricula;

    $this->data[":" . self::DS_COMPLEMENTO] = $this->getDescription($data[self::DS_COMPLEMENTO]);

    $this->objectAudit->setData($this->data);
  }

  public function recoveryIpMachine(): string
  {
    $ipaddress = "";

    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
      $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
      $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
      $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
      $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
      $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
      $ipaddress = "DESCONHECIDO";
    }

    return $ipaddress;
  }

  private function getDescription(string $description): string
  {
    return
      "DESCRIÇÃO:
             {$description}
             --- SQL: {$this->getQueryAudit()}
             --- VALORES: {$this->getColumnsValues($description)}";
  }

  private function getColumnsValues(string $description): string
  {
    $fulDescripiton = "";

    foreach ($this->objectAudit->getColumns() as $column) {
      $value = key_exists(":{$column}", $this->data) ?  $this->data[":{$column}"] : $description;
      $fulDescripiton .= " {$column} : " . $value . ", ";
    }

    return substr($fulDescripiton, 0, strlen($fulDescripiton) - 2);
  }
}
