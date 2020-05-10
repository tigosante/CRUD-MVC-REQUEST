<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/app/core/classes/abstracts/AbModel.php");

class UserDAO extends AbModel
{
    public function verificar_user(UserO $user): bool
    {
        $id = $user->get_id();
        $ds_email = $user->get_ds_email();
        $senha_user = $user->get_senha_user();

        $sql = "SELECT * FROM `USUARIO` WHERE 1=1 ";

        $sql .= $id > -1 ? " AND ID = :ID " : "";
        $sql .= $ds_email ? " AND DS_EMAIL = :DS_EMAIL " : "";
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
