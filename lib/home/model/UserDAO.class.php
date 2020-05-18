<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace home\model;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/config/autoloads/autoload_default.php";

/**
 * namespace: Pacote/path de uma determinada classe.
 * Usado para importar uma determinada classes.
 */

use home\_objetos\UserO;
use core\classes\abstracts\ModelDAO;

/**
 * Objeto de tratamento de dados vindos do DB.
 */
class UserDAO extends ModelDAO
{
    /**
     * Verifica a existência de um usuário no BD.
     */
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

    /**
     * Verifica o objeto recebido e cria ou atualiza o mesmo no DB.
     */
    public function merge(UserO $user): bool
    {
        return $user->get_id() === -1 ? $this->create($user) : $this->update($user->get_id());
    }

    public function create(UserO $user): bool
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

    /**
     * Busca todos, alguns ou apenas 1 usuário.
     */
    public function read(UserO $user): array
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

    /**
     * Atualiza as informações de um determinado usuário no BD.
     */
    public function update(int $id): bool
    {
        $this->sql = "UPDATE USUARIO SET NO_USER= :NO_USER, DS_EMAIL= :DS_EMAIL, SENHA_USER= :SENHA_USER WHERE ID = :ID";
        return $this->pdo->prepare($this->sql)->execute([":ID" => $id]);
    }

    /**
     * Apaga o registro de um determinado usuário do DB;
     */
    public function delete(int $id): bool
    {
        $this->sql = "DELETE FROM USUARIO WHERE ID = :ID";
        return $this->pdo->prepare($this->sql)->execute([":ID" => $id]);
    }
}
