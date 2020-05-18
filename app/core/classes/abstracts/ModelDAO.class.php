<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace core\classes\abstracts;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/config/autoloads/autoload_default.php";


/**
 * namespace: Pacote/path de uma determinada classe.
 * Usado para importar uma determinada classes.
 */

use config\conexoes\ConexaoOracle;
use core\classes\interfaces\IConexao;

/**
 * Abstração de métodos para uso em classes model DAO.
 */
class ModelDAO
{
    public $pdo;
    protected $sql = "";
    protected $parametros = [];

    public function __construct(IConexao $conexao = NULL)
    {
        // if ($conexao === NULL) {
        $this->pdo = ConexaoOracle::getInstance();
        // } else {
        //     $this->pdo = $conexao::getInstance();
        // }
    }

    /**
     * Cria um novo registro em uma tabela no DB.
     */
    protected function create()
    {
        // Implementação.
    }

    /**
     * Busca risgistros de uma determinada tabela no DB usando validações.
     */
    protected function read_by(): array
    {
        // Implementação.
        return array();
    }

    /**
     * Busca todos os dados de uma determinada tabela do DB.
     */
    protected function read_all(): array
    {
        // Implementação.
        return array();
    }

    /**
     * Atualiza um ou mais registros de uma determinada tabela do DB.
     */
    protected function update()
    {
        // Implementação.
    }

    /**
     * Apaga um ou mais registros de uma derterminada tabela do DB.
     */
    protected function delete()
    {
        // Implementação.
        return true;
    }
}