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

    protected function novo_user()
    {
        return $this->daoUser->create();
    }
}

LoginC::init();
