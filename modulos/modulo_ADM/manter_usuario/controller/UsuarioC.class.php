<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace modulo_adm\usuario\controller;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/config/autoloads/autoload_default.php";

/**
 * namespace: Pacote/path/caminho de uma determinada classe..
 * Usado para importar uma determinada classes.
 */

use home\_objetos\UserO;
use modulo_adm\modulo\model\UsuarioM;
use core\classes\abstracts\Controller;

/**
 * Objeto que faz a comunicação de dados entre a o usuário e o model.
 */
class UsuarioC extends Controller
{
    private $model;
    private $usuario;

    public function __construct()
    {
        $this->model = new UsuarioM;
        $this->usuario = new UserO;
        parent::__construct();
    }

    protected function criar_usuario()
    {
        $validacao = $this->usuario->set_all_parametros();
        return $validacao ? $this->model->criar_usuario($this->usuario) : $validacao;
    }
}

UsuarioC::init();