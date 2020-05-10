<?php
define("ROOT", $_SERVER["DOCUMENT_ROOT"], true);

require_once(ROOT . "/app/core/classes/abstracts/AbController.php");
require_once(ROOT . "/app/home/login/model/UserDAO.class.php");
require_once(ROOT . "/app/home/login/model/userO.class.php");

class LoginC extends AbController
{
    private $oUser;
    private $daoUser;

    public function __construct()
    {
        $this->daoUser = new UserDAO;
        parent::__construct();
    }

    protected function login_user()
    {
        $this->oUser = new UserO;
        $this->oUser->set_all_parametros();

        return $this->daoUser->verificar_user($this->oUser);
    }
}

LoginC::init();
