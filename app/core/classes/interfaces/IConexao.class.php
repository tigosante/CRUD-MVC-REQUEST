<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace core\classes\interfaces;

/**
 * Interface de conexão para uso de outros DB no sistema.
 */
interface IConexao
{
    /**
     * Método que verifica se existe a instância de uma determinada conexão.
     * Retorna a mesma caso já exista.
     * Retorna uma nova caso não exista.
     */
    public static function getInstance();

    /**
     * Responsável por informar os erros de conexão.
     */
    public function errorConexao($error);
}