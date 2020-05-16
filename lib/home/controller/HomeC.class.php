<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace home\controller;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/core/autoloads/autoload_default.php";

/**
 * namespace: Pacote/path de uma determinada classe.
 * Usado para importar uma determinada classes.
 */

use home\model\UserDAO;
use home\_objetos\UserO;
use core\classes\abstracts\Controller;

/**
 * Objeto que faz a comunicação de dados entre a o usuário e o model.
 */
class HomeC extends Controller
{
    private $oUser;
    private $daoUser;

    public function __construct()
    {
        $this->oUser = new UserO;
        $this->daoUser = new UserDAO;
        parent::__construct();
    }

    /**
     * Verifica no model se um determinado usuário existe injetando o mesmo na classe model.
     */
    protected function login_user()
    {
        $validacao = $this->oUser->set_all_parametros();
        return $validacao ? $this->daoUser->verificar_user($this->oUser) : $validacao;
    }

    /**
     * Injeta um determinado usuário na classe model e executa um merge.
     */
    protected function merge()
    {
        $validacao = $this->oUser->set_all_parametros();
        return $validacao ? $this->daoUser->merge($this->oUser) : $validacao;
    }

    /**
     * Informa ao model que um novo usuário deve ser criado e seus respectivos dados.
     */
    protected function cria_user()
    {
        $validacao = $this->oUser->set_all_parametros();
        return $validacao ? $this->daoUser->create($this->oUser) : $validacao;
    }

    /**
     * Busca na classe model um determinado usuário.
     */
    protected function busca_user()
    {
        $validacao = $this->oUser->set_all_parametros();
        return $validacao ? $this->daoUser->read($this->oUser) : $validacao;
    }

    /**
     * Injeta as novas informações de um terminado usuário no model e atualiza.
     */
    protected function atualiza_user()
    {
        $validacao = $this->oUser->set_all_parametros();
        return $validacao ? $this->daoUser->update($this->oUser->get_id()) : $validacao;
    }

    /**
     * Informa ao model qual usuário deve ser apagado do DB.
     */
    protected function deleta_user()
    {
        $validacao = $this->oUser->set_all_parametros();
        return $validacao ? $this->daoUser->delete($this->oUser->get_id()) : $validacao;
    }
}

HomeC::init();