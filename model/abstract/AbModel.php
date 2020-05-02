<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/conexao/conexao.php");

abstract class AbModel
{
    protected $pdo;

    public function __construct()
    {
        $this->pdo = Conexao::getInstance();
    }

    public function buscar($comando)
    {
        $id = 1;
        $nome = "Tiago";
        $sobrenome = "Silva";
        $peso = 64.0;

        $comando = "UPDATE `teste` SET `id`= :id,`nome`= :nome,`sobrenome`= :sobrenome,`peso`= :peso WHERE id = :id";

        $stmt = $this->pdo->prepare($comando);

        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":sobrenome", $sobrenome);
        $stmt->bindParam(":peso", $peso);

        return $stmt->execute() ?? $stmt->errorInfo();


        // Mais usado para CRUD com valores vindos da view.
        $comando = $this->pdo->prepare("SELECT * FROM `teste` WHERE ID = :ID");

        // Usado para enviar parametros por variáveis e tratar dados.
        $comando->bindParam(":ID", $id);

        // Aceita valor setado diretamente.
        // $comando->bindValue(":ID", "1");

        if ($comando->execute()) {
            return $comando->fetchAll()[0]["nome"];
        }

        return $comando->errorInfo();

        //  OU

        // Mais usado para executar UPDATES, DELETES ou INSERTS com valores setados.
        // return $this->pdo->query("SELECT * FROM `teste`")->fetchAll()[0]["nome"];
    }
}
