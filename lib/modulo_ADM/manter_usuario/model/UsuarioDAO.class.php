<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace modulo_adm\usuario\model;

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
    public function __construct()
    {
        $sq_user = 1;

        $user = new UserO();

        $user->set_all_parametros();

        $user->create();
        $user->find($sq_user);
        $user->update();
        $user->delete($sq_user);

        $user->merge();
    }
}