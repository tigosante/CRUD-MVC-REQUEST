<?php

namespace core\classes\abstracts;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/core/autoloads/autoload_default.php";

use config\conexoes\ConexaoOracle;
use core\classes\interfaces\IConexao;

abstract class ModelDAO
{
    protected $pdo;

    public function __construct(IConexao $conexao = NULL)
    {
        if ($conexao === NULL) {
            $this->pdo = ConexaoOracle::getInstance();
        } else {
            $this->pdo = $conexao::getInstance();
        }
    }
}