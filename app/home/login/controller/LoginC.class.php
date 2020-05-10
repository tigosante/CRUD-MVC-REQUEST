<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"], true);

require_once(ROOT . "/app/core/classes/abstracts/AbController.php");
require_once(ROOT . "/app/home/login/model/UserDAO.class.php");

class LoginC extends AbController
{
    private $daoUser;

    public function __construct()
    {
        $this->daoUser = new UserDAO;
        parent::__construct();
    }

    protected function login_user()
    {
        return $this->daoUser->verificar_user();
    }

    protected function cria_user()
    {
        return $this->daoUser->create();
    }

    protected function busca_user()
    {
        return $this->daoUser->read();
    }

    protected function atualiza_user()
    {
        return $this->daoUser->update(intval($_REQUEST["id"]));
    }

    protected function deleta_user()
    {
        return $this->daoUser->delete(intval($_REQUEST["id"]));
    }
}

LoginC::init();
