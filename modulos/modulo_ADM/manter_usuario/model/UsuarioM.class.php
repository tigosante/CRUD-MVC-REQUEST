<?php

namespace modulo_adm\modulo\model;

use core\classes\abstracts\ModelDAO;
use home\_objetos\UserO;

class UsuarioM extends ModelDAO
{
    public function buscar_usuarios(): array
    {
        $this->sql = "SELECT NO_USER, DS_EMAIL FROM TRE.TB_USER";

        $stmt = $this->pdo->prepare($this->sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function buscar_usuario_id(int $id): object
    {
        $this->sql = "SELECT NO_USER, DS_EMAIL FROM TRE.TB_USER WHERE NR_MATRICULA = :NR_MATRICULA";

        $stmt = $this->pdo->prepare($this->sql);
        $stmt->bindParam(":NR_MATRICULA", $id);

        $stmt->execute();

        $object = $stmt->fetch(\PDO::FETCH_OBJ);

        $object->NO_USER = "Nome do usuário: {$object->NO_USER}";

        return $object;
    }

    public function criar_usuario(): bool
    {
        $this->sql = "INSERT INTO TRE.TB_USER (NO_USUER, DS_EMAIL, NR_MATRIUCLA) VALUES (:NO_USUER, :DS_EMAIL, :NR_MATRIUCLA)";

        $nr_matricula = 991521;
        $ds_email = "tiago@email.com";

        $stmt = $this->pdo->prepare($this->sql);

        $stmt->bindValue(":NO_USER", "Tiago Silva", \PDO::PARAM_STR);
        $stmt->bindParam(":DS_EMAIL", $ds_email, \PDO::PARAM_STR);
        $stmt->bindColumn(":NR_MATRIUCLA", $nr_matricula, \PDO::PARAM_INT, strlen("{$nr_matricula}"));

        return $stmt->execute();
    }

    public function remover_usuario(int $id): bool
    {
        $this->sql = "DELETE TRE.TB_USER WHERE NR_MATRICULA = :NR_MATRICULA";

        $stmt = $this->pdo->prepare($this->sql);

        return $stmt->execute([":NR_MATRICULA" => $id]);
    }

    public function atualizar_usuario(int $id): bool
    {
        $this->sql = "UPDATE TRE.TB_USER SET(NO_USER = :NO_USER, DS_EMAIL = :DS_EMAIL) WHERE NR_MATRICULA = :NR_MATRICULA";

        $binds = [":NO_USER" => "Tiago Santos", ":DS_EMAIL" => "ts@email.com"];

        $stmt = $this->pdo->prepare($this->sql);
        return $stmt->execute($binds);
    }
}