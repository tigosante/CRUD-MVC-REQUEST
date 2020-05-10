<?php

require_once(ROOT . "/app/core/classes/abstracts/AbModel.php");
require_once(ROOT . "/app/home/login/model/userO.class.php");
require_once(ROOT . "/app/home/login/model/userM.class.php");

class UserDAO extends AbModel
{
    private $mUser;
    private $oUser;

    public function __construct()
    {
        $this->oUser = new UserO;
        $this->mUser = new UserM;
        parent::__construct();
    }

    public function verificar_user(): bool
    {
        $this->oUser->set_all_parametros();

        $sql = $this->mUser->sql_verificar_user($this->oUser);
        $comando = $this->pdo->prepare($sql);

        return ($comando->execute($this->mUser->get_parametos()) && $comando->rowCount() === 1);
    }
}
