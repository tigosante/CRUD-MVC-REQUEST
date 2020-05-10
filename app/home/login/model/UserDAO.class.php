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

    public function merge(int $id = NULL)
    {
        return $id === NULL ? $this->create() : $this->update($id);
    }

    public function create()
    {
        $sql = "INSERT INTO USUARIO ( NO_USER, DS_EMAIL, SENHA_USER)
            VALUES (:NO_USER, :DS_EMAIL, :SENHA_USER)";

        $this->oUser->set_all_parametros();

        $parametros = [
            ":NO_USER" => $this->oUser->get_no_user(),
            ":DS_EMAIL" => $this->oUser->get_ds_email(),
            ":SENHA_USER" => $this->oUser->get_senha_user(),
        ];

        return $this->pdo->prepare($sql)->execute($parametros);
    }

    public function read(int $id = NULL)
    {
        $sql = "SELECT * FROM USUARIO WHERE 1=1 ";
        $parametros = [];

        $this->oUser->set_all_parametros();
        $id_validate = $this->oUser->get_id() > -1 && $id !== NULL;

        if ($this->oUser->get_no_user()) {
            $sql .= "AND NO_USER = :NO_USER ";
            $parametros[] = [":NO_USER" => $this->oUser->get_no_user()];
        }

        if ($this->oUser->get_ds_email()) {
            $sql .= "AND DS_EMAIL = :DS_EMAIL ";
            $parametros[] = [":DS_EMAIL" => $this->oUser->get_ds_email()];
        }

        if ($id_validate) {
            $sql .= "AND ID = :ID ";
            $parametros[] = [":ID" => $this->oUser->get_id()];
        }

        $comando = $this->pdo->prepare($sql);
        $comando->execute($parametros);

        return $id_validate ? $comando->fetch() : $comando->fetchAll();
    }

    public function update(int $id)
    {
        $sql = "UPDATE USUARIO SET NO_USER= :NO_USER, DS_EMAIL= :DS_EMAIL, SENHA_USER= :SENHA_USER WHERE ID = :ID";

        $this->oUser->set_id($id);

        return $this->pdo->prepare($sql)->execute([":ID" => $this->oUser->get_id()]);
    }

    public function delete(int $id)
    {
        $sql = "DELETE FROM USUARIO WHERE ID = :ID";

        $this->oUser->set_id($id);

        return $this->pdo->prepare($sql)->execute([":ID" => $this->oUser->get_id()]);
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

        $sql = "SELECT * FROM USUARIO WHERE 1=1 ";

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
