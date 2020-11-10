<?php

namespace core\classes\simple_crud_helper\Audit;

use core\classes\interfaces\Audit\AuditInterface;
use core\classes\interfaces\Audit\AuditObjectInterface;
use core\classes\UsuarioLogado;

class Audit implements AuditInterface
{
    /**
     * @var AuditObjectInterface $objectAudit
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

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): void
    {
        $this->data[":" . self::CD_CANAL] = $this->objectAudit->get_cd_canal();
        $this->data[":" . self::DS_IP_MAQUINA] = $this->recuperar_ip_maquina_usuario();

        $this->data[":" . self::CD_EVENTO] = $data[self::CD_EVENTO];
        $this->data[":" . self::NR_MATRICULA] =  UsuarioLogado::getInstance()->nr_matricula;

        $this->data[":" . self::DS_COMPLEMENTO] = $this->get_ds_complemento_total($data[self::DS_COMPLEMENTO]);

        $this->objectAudit->setData($this->data);
    }

    public function recuperar_ip_maquina_usuario(): string
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

    private function get_ds_complemento_total(string $ds_complemento): string
    {
        return
            "DESCRIÇÃO:
             {$ds_complemento}
             --- SQL: {$this->getQueryAudit()}
             --- VALORES: {$this->get_columns_values($ds_complemento)}";
    }

    private function get_columns_values(string $ds_complemento): string
    {
        $fulDescripiton = "";

        foreach ($this->objectAudit->getColumns() as $column) {
            $value = key_exists(":{$column}", $this->data) ?  $this->data[":{$column}"] : $ds_complemento;
            $fulDescripiton .= " {$column} : " . $value . ", ";
        }

        return substr($fulDescripiton, 0, strlen($fulDescripiton) - 2);
    }
}
