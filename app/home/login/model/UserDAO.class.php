<?php

require_once(ROOT . "/app/core/classes/abstracts/AbModel.php");
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



/*
<?php
require_once(ROOT . "/app/core/classes/abstracts/AbModel.php");
require_once(ROOT . "/app/home/login/model/userO.class.php");

class UserDAO extends AbModel
{
    private $oUser;

    public function __construct()
    {
        $this->oUser = new UserO;
        parent::__construct();
    }

    public function verificar_user(): bool
    {
        $this->oUser->set_all_parametros();

        $id         = $this->oUser->get_id();
        $ds_email   = $this->oUser->get_ds_email();
        $senha_user = $this->oUser->get_senha_user();

        $sql = "SELECT * FROM `USUARIO` WHERE 1=1 ";

        $sql .= $id > -1    ? " AND ID         = :ID "         : "";
        $sql .= $ds_email   ? " AND DS_EMAIL   = :DS_EMAIL "   : "";
        $sql .= $senha_user ? " AND SENHA_USER = :SENHA_USER " : "";

        $comando = $this->pdo->prepare($sql);

        $parametros = [
            ":DS_EMAIL" => $ds_email,
            ":SENHA_USER" => $senha_user
        ];

        if ($id > -1) {
            $parametros[":ID"] = $id;
        }

        return ($comando->execute($parametros) && $comando->rowCount() === 1);
    }
}

*/
