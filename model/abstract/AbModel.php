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
        // return $comando();

        // Mais usado para SELECTS
        $comando = $this->pdo->prepare("SELECT * FROM `teste` WHERE ID = :ID");

        if ($comando->execute()) {
            $valor = "1";
            // Usado para enviar parametros por variáveis e tratar dados.
            $comando->bindParam(":ID", $valor);

            // Aceita valor setado diretamente.
            // $comando->bindValue(":ID", "1");

            return $comando->fetchAll()[0]["nome"];
        }

        return $comando->errorInfo();

        //  OU

        // Mais usado para executar UPDATES, DELETES ou INSERTS.
        // return $this->pdo->query("SELECT * FROM `teste`")->fetchAll()[0]["nome"];
    }
}
