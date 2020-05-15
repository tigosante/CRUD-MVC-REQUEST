<?php

namespace core\classes\abstracts;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/core/autoloads/autoload_default.php";

use config\conexoes\Conexao;
use core\classes\interfaces\IConexao;

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
