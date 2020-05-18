<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace modulo_tre\_objetos;

use core\classes\abstracts\ObjetoDAO;

/**
 * Objeto que representa a tabela TB_MODULO.
 */
class TreinamentoO extends ObjetoDAO
{
    private $name = "";
    private $email = "";
    private $sq_treinamento = -1;

    const NAME = "NAME";
    const EMAIL = "EMAIL";
    const SQ_TREINAMENTO = "SQ_TREINAMENTO";

    public function __construct()
    {
        parent::__construct("TB_TREINAMENTO", [self::NAME, self::EMAIL]);
    }

    /**
     * Get the value of name
     *
     * @return  mixed
     */
    public function get_name()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param   mixed  $name
     *
     * @return  self
     */
    public function set_name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of email
     *
     * @return  mixed
     */
    public function get_email()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param   mixed  $email
     *
     * @return  self
     */
    public function set_email($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of sq_treinamento
     *
     * @return  mixed
     */
    public function get_sq_treinamento()
    {
        return $this->sq_treinamento;
    }

    /**
     * Set the value of sq_treinamento
     *
     * @param   mixed  $sq_treinamento
     *
     * @return  self
     */
    public function set_sq_treinamento($sq_treinamento)
    {
        $this->sq_treinamento = $sq_treinamento;

        return $this;
    }
}