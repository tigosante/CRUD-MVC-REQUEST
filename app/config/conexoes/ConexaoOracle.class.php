<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace config\conexoes;

/**
 * namespace: Pacote/path de uma determinada classe.
 * Usado para importar uma determinada classes.
 */

use core\classes\interfaces\IConexao;

/**
 * Objeto que realiza a conexão com o Oracle DB e implementa a interface IConexao.
 * Cria a conexão usando PDO - PHP Data Objects.
 */
class ConexaoOracle implements IConexao
{
    private static $conexao;

    private static $dsn = "mysql:host=localhost;dbname=mysql";
    private static $options = [\PDO::FETCH_ASSOC];
    private static $username = "tiago";
    private static $password = "0TwU9XYElaK8AIms";

    public function __construct()
    {
        try {
            self::$conexao = new \PDO(self::$dsn, self::$username, self::$password, self::$options);
        } catch (\PDOException $e) {
            $this->errorConexao($e);
        }
    }

    /**
     * Método que verifica se existe a instância de uma determinada conexão.
     * Retorna a mesma caso já exista.
     * Retorna uma nova caso não exista.
     */
    public static function getInstance()
    {
        if (!isset(self::$conexao)) {
            self::$conexao = new \PDO(self::$dsn, self::$username, self::$password);
        }

        return self::$conexao;
    }

    /**
     * Responsável por informar os erros de conexão.
     */
    public function errorConexao($error)
    {
        $error_message = $error->getMessage();
        echo $error_message;
        exit;
    }
}