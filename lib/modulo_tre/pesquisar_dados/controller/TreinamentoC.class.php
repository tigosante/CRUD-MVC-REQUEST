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
use modulo_tre\_objetos\TreinamentoO;
use modulo_tre\pesquisar_dados\View\TreinamentoV;
use modulo_tre\pesquisar_dados\model\TreinamentoM;

/**
 * Objeto que faz a comunicação de dados entre a o usuário e o model.
 */
class TreinamentoC extends Controller
{
    private $model;
    private $oTreinamento;
    private $vTreinamento;

    public function __construct()
    {
        $this->model = new TreinamentoM;
        $this->oTreinamento = new TreinamentoO;
        $this->vTreinamento = new TreinamentoV;
    }

    protected function get_dados()
    {
        if (!$this->oTreinamento->set_all_parametros()) {
            return false;
        }

        $dados = $this->model->get_dados($this->oTreinamento);
        return $this->vTreinamento->montar_tabela($dados);
    }
}

TreinamentoC::init();