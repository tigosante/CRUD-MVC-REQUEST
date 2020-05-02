<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/UsuarioModel.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/UsuarioView.php");

class UsuarioController
{
    private $view;
    private $model;
    public function __construct()
    {
        $this->view = new UsuarioView;
        $this->model = new UsuarioModel;

        $acao = $_REQUEST["acao"];
        echo json_encode($this->$acao());
    }

    protected function usuarios()
    {
        var_dump("ad");
        return $this->view->montar_tabela_paginacao($this->model->buscar("usuarios"));
    }
}
