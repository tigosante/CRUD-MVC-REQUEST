<?php

namespace modulo_adm\modulo\model;

use core\classes\abstracts\ModelDAO;
use home\_objetos\UserO;

class UsuarioM extends ModelDAO
{
    public function criar_usuario(UserO $usuario): bool
    {
        return $usuario->create();
    }
}