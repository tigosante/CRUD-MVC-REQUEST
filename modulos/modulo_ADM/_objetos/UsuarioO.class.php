<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace modulo_adm\_objetos;

/**
 * Objeto que representa a tabela TB_USUARIO.
 */
class UsuarioO
{
    private $no_usuario;
    private $nr_matricula;

    /**
     * Retorna o valor da variavel no_usuario;
     */
    public function get_no_usuario()
    {
        return $this->no_usuario;
    }

    /**
     * Seta uma string na variável no_usuario.
     *
     * @return  void
     */
    public function set_no_usuario($no_usuario)
    {
        $this->no_usuario = $no_usuario;
    }

    /**
     * Retorna o valor da variável nr_matricula.
     */
    public function get_nr_matricula()
    {
        return $this->nr_matricula;
    }

    /**
     * Seta um valor numérico na variável nr_matricula.
     *
     * @return  void
     */
    public function set_nr_matricula($nr_matricula)
    {
        $this->nr_matricula = intval($nr_matricula);
    }
}