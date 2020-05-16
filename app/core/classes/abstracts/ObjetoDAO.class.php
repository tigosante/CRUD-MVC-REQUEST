<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace core\classes\abstracts;

/**
 * Abstração de métodos para uso em classes Objeto.
 */
abstract class ObjetoDAO
{
    public function set_all_parametros(): bool
    {
        foreach ($_REQUEST as $chave => $valor) {
            $metodo = "set_" . $chave;

            if ($chave !== "acao" && method_exists($this, $metodo)) {
                try {
                    $this->$metodo($valor);
                } catch (\Throwable $e) {
                    return false;
                }
            }
        }

        return true;
    }
}