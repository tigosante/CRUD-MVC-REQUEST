<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace modulo_adm\usuario\model;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/config/autoloads/autoload_default.php";

/**
 * namespace: Pacote/path de uma determinada classe.
 * Usado para importar uma determinada classes.
 */

use core\classes\abstracts\ModelDAO;
use home\_objetos\UserO;

/**
 * nome do pacote/path ao qual esta classe pertence.
 */
class UsuarioDAO extends ModelDAO
{

    protected function criar_usuario(UserO $usuario): bool
    {
        // Implementação da regra de negócio.

        return $usuario->create();
    }
}
