<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace config\conexoes;

/**
 * namespace: Pacote/path/caminho de uma determinada classe..
 * Usado para importar uma determinada classes.
 */

use core\classes\interfaces\IConexao;

/**
 * Objeto que realiza a conexão com o Oracle DB e implementa a interface IConexao.
 * Cria a conexão usando PDO - PHP Data Objects.
 */
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

    /**
     * Método que verifica se existe a instância de uma determinada conexão.
     * Retorna a mesma caso já exista.
     * Retorna uma nova caso não exista.
     */
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

    /**
     * Responsável por informar os erros de conexão.
     */
    public static function errorConexao($error): void
    {
        throw new \InvalidArgumentException("Error conexão:\n" . $error->getMessage(), 1);
    }
}