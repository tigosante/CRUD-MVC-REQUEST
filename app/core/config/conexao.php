<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/interface/IConexao.php");

class Conexao implements IConexao
{
    private static $conexao;

    private static $dsn = "mysql:host=localhost;dbname=mysql";
    private static $username = "user_teste";
    private static $password = "123456";

    public function __construct()
    {
        try {
            self::$conexao = new PDO(self::$dsn, self::$username, self::$password);
        } catch (PDOException $e) {
            $this->errorConexao($e);
        }
    }

    public static function getInstance()
    {
        if (self::$conexao === NULL) {
            self::$conexao = new PDO(self::$dsn, self::$username, self::$password);
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
