<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace modulo_tre\pesquisar_dados\controller;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/config/autoloads/autoload_default.php";

/**
 * namespace: Pacote/path/caminho de uma determinada classe.
 * Usado para importar uma determinada classes.
 */

use core\classes\abstracts\Controller;
use modulo_tre\pesquisar_dados\View\TreinamentoV;
use modulo_tre\pesquisar_dados\model\TreinamentoM;

/**
 * Objeto que faz a comunicação de dados entre a o usuário e o model.
 */
class TreinamentoC extends Controller
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->view = new TreinamentoV;
        $this->model = new TreinamentoM;
        parent::__construct();
    }

    protected function get_dados()
    {
        $dados = $this->model->get_dados();
        return $this->view->montar_tabela($dados);
    }

    protected function update_dado()
    {
        return $this->model->update_dado();
    }

    protected function set_novo_dado()
    {
        return $this->model->set_novo_dado();
    }

    protected function delete_dado()
    {
        return $this->model->delete_dado();
    }
}

TreinamentoC::init();