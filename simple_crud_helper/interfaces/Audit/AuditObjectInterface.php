<?php

namespace core\classes\interfaces\Audit;

interface AuditObjectInterface
{
    /**
     * @return void
     */
    public function set_ds_complemento(string $ds_complemento);

    /**
     * @return string
     */
    public function get_ds_complemento();

    /**
     * @return void
     */
    public function set_ds_ip_maquina(string $ds_ip_maquina);

    /**
     * @return string
     */
    public function get_ds_ip_maquina();

    /**
     * @return void
     */
    public function set_nr_matricula(int $nr_matricula);

    /**
     * @return int
     */
    public function get_nr_matricula();

    /**
     * @return void
     */
    public function set_dt_auditoria(string $dt_auditoria);

    /**
     * @return string
     */
    public function get_dt_auditoria();

    /**
     * @return void
     */
    public function set_cd_evento(int $cd_evento);

    /**
     * @return int
     */
    public function get_cd_evento();

    /**
     * @return void
     */
    public function set_cd_canal(int $cd_canal);

    /**
     * @return int
     */
    public function get_cd_canal();

    /**
     * @return string
     */
    public function getQuery();

    /**
     * @return bool
     */
    public function create(\PDO &$connection);

    /**
     * @return array
     */
    public function getData();

    /**
     * @return void
     */
    public function setData(array $data);

    /**
     * @return array
     */
    public function getColumns();
}
