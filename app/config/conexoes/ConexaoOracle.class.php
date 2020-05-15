<?php

namespace config\conexoes;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/config/autoloads/autoload_default.php";

use core\classes\interfaces\IConexao;

class ConexaoOracle implements IConexao
{
    private static $conexao;

    private static $dsn = "mysql:host=localhost;dbname=mysql";
    private static $options = [\PDO::FETCH_ASSOC];
    private static $username = "root";
    private static $password = "";

    public function __construct()
    {
        try {
            self::$conexao = new \PDO(self::$dsn, self::$username, self::$password, self::$options);
        } catch (\PDOException $e) {
            $this->errorConexao($e);
        }
    }

    public static function getInstance()
    {
        if (self::$conexao === NULL) {
            self::$conexao = new \PDO(self::$dsn, self::$username, self::$password);
        }

        return self::$conexao;
    }

    public function errorConexao($error)
    {
        $error_message = $error->getMessage();
        echo $error_message;
        exit;
    }
}