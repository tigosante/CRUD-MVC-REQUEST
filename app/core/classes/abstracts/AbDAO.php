<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "/app/core/classes/interfaces/IConexao.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/app/core/config/conexao.php");

abstract class AbDAO
{
    protected $pdo;

    public function __construct(IConexao $conexao = NULL)
    {
        if ($conexao === NULL) {
            $this->pdo = Conexao::getInstance();
        } else {
            $this->pdo = $conexao::getInstance();
        }
    }
}
