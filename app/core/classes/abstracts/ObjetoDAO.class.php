<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace core\classes\abstracts;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/config/autoloads/autoload_default.php";

/**
 * namespace: Pacote/path/caminho de uma determinada classe..
 * Usado para importar uma determinada classes.
 */

use core\classes\abstracts\ModelDAO;
use PDO;

/**
 * Abstração de métodos para uso em classes Objeto.
 */
abstract class ObjetoDAO extends ModelDAO
{
    protected $table;
    protected $binds;
    protected $db_name;
    protected $columns;
    protected $columns_binds;

    public function __construct(string $table, array $columns, string $db_name = "TRE.")
    {
        $this->table = $table;
        $this->db_name = $db_name;
        $this->columns = $columns;
    }

    /**
     * Executa o método set do objeto filho que está chamando a classe.
     * Usa o $REQUEST para identificar quais métodos set chamar.
     *
     * @return bool
     */
    public function set_all_parametros(): bool
    {
        foreach ($_REQUEST as $chave => $valor) {
            $metodo = "set_" . $chave;

            if ($chave !== "acao" && method_exists($this, $metodo)) {
                try {
                    $this->$metodo($valor);
                } catch (\Throwable $e) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Executa um INSERT ou UPDATE baseado no conteudo no SQ do objeto filho.
     * $get_data Retorna o dado inserido no banco.
     * $fetch_method Formato em que o dado será retornado.
     *
     * @return array|bool
     */
    public function merge($get_data = false, $fetch_method = PDO::FETCH_OBJ)
    {
        return empty($this->get_sq_value()) ? $this->create($get_data, $fetch_method) : $this->update();
    }

    /**
     * Cria um novo registro do objeto filho no DB.
     * $get_data Retorna o dado inserido no banco.
     * $fetch_method Formato em que o dado será retornado.
     *
     * @return bool
     */
    public function create($get_data = false, $fetch_method = PDO::FETCH_OBJ)
    {
        $this->add_sq_binds();

        $query = "INSERT INTO {$this->db_name}{$this->table} ({join(', ', $this->columns)}) VALUES (:{join(', :', $this->columns)})";

        $data = $this->pdo->prepare($query);
        $result = $data->execute($this->get_binds());

        if ($result) {
            if ($get_data) {
                return $this->get_last_data($fetch_method);
            }

            return $result;
        }

        return $result;
    }

    /**
     * Buca um registro do objeto filho dentro do DB.
     * $sq_value SQ do registro informado.
     * $fetch_method Formato em que o dado será retornado.
     *
     * @return bool
     */
    public function find_by_sq(int $sq_value, $fetch_method = PDO::FETCH_OBJ): array
    {
        $query = "SELECT * FROM {$this->db_name}{$this->table} WHERE {$this->get_sq_name()} = :{$this->get_sq_name()}";
        $data = $this->pdo->prepare($query);
        $data->execute([":{$this->get_sq_name()}" => $sq_value]);

        if ($data->rowCount() > 0) {
            return $data->fetch($fetch_method);
        }

        return [];
    }

    /**
     * Buca todos os registro do objeto filho dentro do DB.
     * $fetch_method Formato em que o dado será retornado.
     *
     * @return array
     */
    public function find_all($fetch_method = PDO::FETCH_OBJ): array
    {
        $query = "SELECT * FROM {$this->db_name}{$this->table}";
        $data = $this->pdo->prepare($query);

        if ($data->execute()) {
            return $data->fetchAll($fetch_method);
        }

        return [];
    }

    /**
     * Atualiza os dados do objeto gilho a partir dos dados informados via @set_all_parametros.
     *
     * @return bool
     */
    public function update(): bool
    {
        $this->add_sq_binds();
        $this->load_binds();

        $query = "UPDATE {$this->db_name}{$this->table} SET {join(', ', $this->columns_binds)} WHERE {$this->get_sq_name()} = :{$this->get_sq_name()}";
        return $this->pdo->prepare($query)->execute($this->get_binds());
    }

    /**
     * Deleta registros do objeto filho dentro do DB.
     * $sq_value SQ do registro.
     * Pode deletar o registro que foi carregado a partir dos dados informado via @set_all_parametros.
     *
     * @return bool
     */
    public function delete(int $sq_value = -1): bool
    {
        if ($sq_value < 0) {
            $sq_value = $this->get_sq_value();
        }

        $query = "DELETE {$this->db_name}{$this->table} WHERE {$this->get_sq_name()} = :{$this->get_sq_name()}";
        return $this->pdo->prepare($query)->execute([":{$this->get_sq_name()}" => $sq_value]);
    }

    /**
     * Busca o último registro cadastrado do objeto filho dentro do DB.
     * $fetch_method Formato em que o dado será retornado.
     *
     * @return array
     */
    public function get_last_data($fetch_method = PDO::FETCH_OBJ): array
    {
        $query = "SELECT * FROM {$this->db_name}{$this->table} WHERE {$this->get_sq_name()} = (SELECT MAX({$this->get_sq_name()}) FROM {$this->db_name}{$this->table})";
        $data = $this->pdo->prepare($query);

        if ($data->execute()) {
            return $data->fetch($fetch_method);
        }

        return [];
    }

    /**
     * Retorno uma query INSERT baseada no objeto filho.
     *
     * @return string
     */
    public function get_query_insert(): string
    {
        return "INSERT INTO {$this->db_name}{$this->table} ({$this->get_columns()}) VALUES ({$this->get_columns_binds()})";
    }

    /**
     * Retorno uma query SELECT baseada no objeto filho.
     *
     * @return string
     */
    public function get_query_select(): string
    {
        return "SELECT * FROM {$this->db_name}{$this->table}  WHERE 1=1 ";
    }

    /**
     * Retorno uma query UPDATE baseada no objeto filho.
     *
     * @return string
     */
    public function get_query_update(): string
    {
        $this->load_binds();

        return "UPDATE {$this->db_name}{$this->table} SET {join(', ', $this->columns_binds)}  WHERE 1=1 ";
    }

    /**
     * Retorno uma query DELETE baseada no objeto filho.
     *
     * @return string
     */
    public function get_query_delete(): string
    {
        return "DELETE {$this->db_name}{$this->table}  WHERE 1=1 ";
    }

    /**
     * Adiciona aos binds a chave e valor da SQ do objeto filho.
     *
     * @return void
     */
    private function add_sq_binds(): void
    {
        array_push($this->binds, [":{$this->get_sq_name()}" => $this->get_sq_value()]);
    }

    /**
     * Carrega os dados para bind.
     *
     * @return void
     */
    private function load_binds(): void
    {
        foreach ($this->columns as $column) {
            array_push($this->columns_binds, " {$column} = :{$column}");
        }
    }

    /**
     * Retorna o nome da SQ do objeto filho.
     *
     * @return string
     */
    private function get_sq_name(): string
    {
        return "SQ_" . substr($this->table, 3);
    }

    /**
     * Retorna o valor da SQ do objeto filho.
     *
     */
    private function get_sq_value()
    {
        $get_sq = "get_" . strtolower($this->get_sq_name());

        try {
            return $this->$get_sq();
        } catch (\Throwable $th) {
            return null;
        }
    }

    /**
     * Retorna todas as binds baseado nos dados carregados no objeto filho.
     *
     * @return string
     */
    private function get_binds(): string
    {
        foreach ($this->columns as $column) {
            $method_name = "get_" . strtolower($column);

            array_push($this->binds, [":{$column}" => $this->$method_name()]);
        }

        return join(", ", $this->binds);
    }

    /**
     * Retorna todas as colunas do objeto filho.
     *
     * @return string
     */
    private function get_columns(): string
    {
        return join(", ", $this->columns);
    }

    /**
     * Retorna todas as colunas de bind baseado no dados carregados no objeto filho.
     *
     * @return string
     */
    private function get_columns_binds(): string
    {
        return ":" . join(", ", $this->columns);
    }
}