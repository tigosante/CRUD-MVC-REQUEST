<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "_classes_abstratas/AbstractController.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "modulo_adm/model/manter_usuario/objeto/Usuario.objeto.php");

class UsuarioController extends AbstractControllerCore
{
    private $objeto;

    public function __construct()
    {
        $this->objeto = new UsuarioObjeto;
        parent::__construct();
    }

    public function get_usuario()
    {
        $this->enviar_parametro();
        echo $this->montar_tabela($this->model->get($this->objeto));
    }

    public function get_dados_pagina()
    {
        $this->enviar_parametro();
        echo $this->$this->model->get($this->objeto, "CLOB");
    }

    public function get_combo()
    {
        $this->enviar_parametro();
        echo $this->$this->model->get($this->objeto, "combo");
    }
}

UsuarioController::init();
