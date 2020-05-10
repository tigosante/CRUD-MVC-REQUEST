<?php
require_once(ROOT . "/app/home/login/model/userO.class.php");

class UserM
{
    private $parametos = [];

    public function get_parametos(): array
    {
        return $this->parametos;
    }

    public function sql_verificar_user(UserO $user): string
    {
        $sql = "SELECT * FROM `USUARIO` WHERE 1=1 ";

        $id = $user->get_id();
        $ds_email = $user->get_ds_email();
        $senha_user = $user->get_senha_user();

        $sql .= $id > -1 ? " AND ID = :ID " : "";
        $sql .= $ds_email ? " AND DS_EMAIL = :DS_EMAIL " : "";
        $sql .= $senha_user ? " AND SENHA_USER = :SENHA_USER " : "";

        $this->parametos = [
            ":DS_EMAIL" => $ds_email,
            ":SENHA_USER" => $senha_user
        ];

        if ($id > -1) {
            $this->parametos[":ID"] = $id;
        }

        return $sql;
    }
}
