<?php

namespace src\interfaces\audit;

interface AuditObjectInterface
{
    /**
     * @return void
     */
    public function set_ds_complemento(string $ds_complemento): void;

    /**
     * @return string
     */
    public function get_ds_complemento(): string;

    /**
     * @return void
     */
    public function set_ds_ip_maquina(string $ds_ip_maquina): void;

    /**
     * @return string
     */
    public function get_ds_ip_maquina(): string;

    /**
     * @return void
     */
    public function set_nr_matricula(int $nr_matricula): void;

    /**
     * @return int
     */
    public function get_nr_matricula(): int;

    /**
     * @return void
     */
    public function set_dt_auditoria(string $dt_auditoria): void;

    /**
     * @return string
     */
    public function get_dt_auditoria(): string;

    /**
     * @return void
     */
    public function set_cd_evento(int $cd_evento): void;

    /**
     * @return int
     */
    public function get_cd_evento(): int;

    /**
     * @return void
     */
    public function set_cd_canal(int $cd_canal): void;

    /**
     * @return int
     */
    public function get_cd_canal(): int;

    /**
     * @return string
     */
    public function getQuery(): string;

    /**
     * @return bool
     */
    public function create(\PDO &$connection): bool;

    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @return void
     */
    public function setData(array $data): void;

    /**
     * @return array
     */
    public function getColumns(): array;
}
