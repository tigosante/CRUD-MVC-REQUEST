<?php

namespace home\model;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/core/autoloads/autoload_default.php";

use home\model\UserO;

class UserDAO extends AbDAO
{
    private $sql = "";
    private $parametros = [];

    public function verificar_user(UserO $user): bool
    {
        $this->sql = "SELECT * FROM USUARIO WHERE 1=1 ";

        $this->sql .= $user->get_id() > -1    ? " AND ID         = :ID "         : "";
        $this->sql .= $user->get_ds_email()   ? " AND DS_EMAIL   = :DS_EMAIL "   : "";
        $this->sql .= $user->get_senha_user() ? " AND SENHA_USER = :SENHA_USER " : "";

        $comando = $this->pdo->prepare($this->sql);

        $this->parametros = [
            ":" . $user::DS_EMAIL => $user->get_ds_email(),
            ":" . $user::SENHA_USER => $user->get_senha_user(),
        ];

        if ($user->get_id() > -1) {
            $this->parametros[":ID"] = $user->get_id();
        }

        return ($comando->execute($this->parametros) && $comando->rowCount() === 1);
    }

    public function merge(UserO $user)
    {
        return $user->get_id() === -1 ? $this->create($user) : $this->update($user->get_id());
    }

    public function create(UserO $user)
    {
        $this->sql = "INSERT INTO USUARIO (NO_USER, DS_EMAIL, SENHA_USER)
            VALUES (:NO_USER, :DS_EMAIL, :SENHA_USER)";

        $this->parametros = [
            ":NO_USER" => $user->get_no_user(),
            ":DS_EMAIL" => $user->get_ds_email(),
            ":SENHA_USER" => $user->get_senha_user(),
        ];

        return $this->pdo->prepare($this->sql)->execute($this->parametros);
    }

    public function read(UserO $user)
    {
        $this->sql = "SELECT * FROM USUARIO WHERE 1=1 ";
        $this->parametros = [];

        $id_validate = $user->get_id() > -1;

        if ($user->get_no_user()) {
            $this->sql .= "AND NO_USER = :NO_USER ";
            $this->parametros[] = [":NO_USER" => $user->get_no_user()];
        }

        if ($user->get_ds_email()) {
            $this->sql .= "AND DS_EMAIL = :DS_EMAIL ";
            $this->parametros[] = [":DS_EMAIL" => $user->get_ds_email()];
        }

        if ($id_validate) {
            $this->sql .= "AND ID = :ID ";
            $this->parametros[] = [":ID" => $user->get_id()];
        }

        $comando = $this->pdo->prepare($this->sql);
        $comando->execute($this->parametros);

        return $id_validate ? $comando->fetch() : $comando->fetchAll();
    }

    public function update(int $id)
    {
        $this->sql = "UPDATE USUARIO SET NO_USER= :NO_USER, DS_EMAIL= :DS_EMAIL, SENHA_USER= :SENHA_USER WHERE ID = :ID";
        return $this->pdo->prepare($this->sql)->execute([":ID" => $id]);
    }

    public function delete(int $id)
    {
        $this->sql = "DELETE FROM USUARIO WHERE ID = :ID";
        return $this->pdo->prepare($this->sql)->execute([":ID" => $id]);
    }
}