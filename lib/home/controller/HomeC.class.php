<?php

namespace home\controller;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/core/autoloads/autoload_default.php";

use home\model\UserO;
use home\model\UserDAO;
use core\classes\abstracts\AbController;

class HomeC extends AbController
{
    private $oUser;
    private $daoUser;

    public function __construct()
    {
        $this->oUser = new UserO;
        $this->daoUser = new UserDAO;
        parent::__construct();
    }

    protected function login_user()
    {
        $validacao = $this->oUser->set_all_parametros();
        return $validacao ? $this->daoUser->verificar_user($this->oUser) : $validacao;
    }

    protected function merge()
    {
        $validacao = $this->oUser->set_all_parametros();
        return $validacao ? $this->daoUser->merge($this->oUser) : $validacao;
    }

    protected function cria_user()
    {
        $validacao = $this->oUser->set_all_parametros();
        return $validacao ? $this->daoUser->create($this->oUser) : $validacao;
    }

    protected function busca_user()
    {
        $validacao = $this->oUser->set_all_parametros();
        return $validacao ? $this->daoUser->read($this->oUser) : $validacao;
    }

    protected function atualiza_user()
    {
        $validacao = $this->oUser->set_all_parametros();
        return $validacao ? $this->daoUser->update($this->oUser->get_id()) : $validacao;
    }

    protected function deleta_user()
    {
        $validacao = $this->oUser->set_all_parametros();
        return $validacao ? $this->daoUser->delete($this->oUser->get_id()) : $validacao;
    }
}

HomeC::init();