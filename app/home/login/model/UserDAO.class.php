<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/app/core/classes/abstracts/AbModel.php");

class UserDAO extends AbModel
{
    public function verificar_user(UserO $user): bool
    {
        $id = $user->get_id();
        $sql = "SELECT * FROM `USUARIO` WHERE 1=1 ";

        $sql .= $id > -1 ? " AND ID = :ID " : "";
        $sql .= $user->get_ds_email() ? " AND DS_EMAIL = :DS_EMAIL " : "";
        $sql .= $user->get_senha_user() ? " AND SENHA_USER = :SENHA_USER " : "";

        $comando = $this->pdo->prepare($sql);

        $parametros = [
            ":DS_EMAIL" => $user->get_ds_email(),
            ":SENHA_USER" => $user->get_senha_user()
        ];

        if ($id > -1) {
            $parametros[":ID"] = $id;
        }


        return ($comando->execute($parametros) && $comando->rowCount() === 1);
    }
}
