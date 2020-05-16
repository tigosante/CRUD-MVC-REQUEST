<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace modulo_adm\_objetos;

/**
 * Objeto que representa a tabela TB_MODULO.
 */
class ModuloO
{
    private $cd_modulo;


    /**
     * Retorna o valor da variavel cd_modulo;
     */
    public function get_cd_modulo()
    {
        return $this->cd_modulo;
    }

    /**
     * Seta uma string na variável cd_modulo.
     *
     * @return  self
     */
    public function set_cd_modulo($cd_modulo)
    {
        $this->cd_modulo = $cd_modulo;
    }
}