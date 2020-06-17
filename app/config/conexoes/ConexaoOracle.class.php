<?php


namespace config\conexoes;

use core\classes\interfaces\IConexao;

abstract class ConexaoOracle implements IConexao
{
    /**
     * @param PDO $conexao
     */
    private static $conexao;

    private static $dsn = "mysql:host=localhost;dbname=mysql";
    private static $options = [\PDO::FETCH_ASSOC];
    private static $username = "USR_TREINAMNETO";
    private static $password = "fhX7VgCniXfkQ8nb";

    public static function getInstance(): \PDO
    {
        if (!isset(self::$conexao)) {
            self::criarConexao();
        }

        return self::$conexao;
    }

    private static function criarConexao(): void
    {
        try {
            self::$conexao = new \PDO(self::$dsn, self::$username, self::$password, self::$options);
        } catch (\PDOException $e) {
            self::errorConexao($e);
        }
    }

    public static function errorConexao(\PDOException $error): void
    {
        throw new \InvalidArgumentException("Error conexão:\n" . $error->getMessage(), 1);
    }
}