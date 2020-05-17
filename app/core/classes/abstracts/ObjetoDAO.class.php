<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace core\classes\abstracts;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/core/autoloads/autoload_default.php";

/**
 * namespace: Pacote/path de uma determinada classe.
 * Usado para importar uma determinada classes.
 */

use core\classes\abstracts\ModelDAO;

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

    public function __construct(string $table, array $columns, string $db_name = "PPC.")
    {
        $this->table = $table;
        $this->db_name = $db_name;
        $this->columns = $columns;
    }

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

    public function merge()
    {
        return empty($this->get_sq_value()) ? $this->create() : $this->update();
    }

    public function create()
    {
        $this->add_sq_binds();

        $query = "INSERT INTO {$this->db_name}{$this->table} ({join(', ', $this->columns)}) VALUES (:{join(', :', $this->columns)})";
        return $this->pdo->prepare($query)->execute($this->get_binds());
    }

    public function find(int $sq_value)
    {
        $query = "SELECT * FROM {$this->db_name}{$this->table} WHERE {$this->get_sq_name()} = :{$this->get_sq_name()}";
        $data = $this->pdo->prepare($query);
        $data->execute([":{$this->get_sq_name()}" => $sq_value]);

        return $data->fetch(\PDO::FETCH_OBJ);
    }

    public function update(): bool
    {
        $this->add_sq_binds();

        foreach ($this->columns as $column) {
            array_push($this->columns_binds, " {$column} = :{$column}");
        }

        $query = "UPDATE {$this->db_name}{$this->table} SET {join(', ', $this->columns_binds)} WHERE {$this->get_sq_name()} = :{$this->get_sq_name()}";
        return $this->pdo->prepare($query)->execute($this->get_binds());
    }

    public function delete(int $sq_value): bool
    {
        $query = "DELETE {$this->db_name}{$this->table} WHERE {$this->get_sq_name()} = :{$this->get_sq_name()}";
        return $this->pdo->prepare($query)->execute([":{$this->get_sq_name()}" => $sq_value]);
    }

    private function add_sq_binds(): void
    {
        array_push($this->binds, [":{$this->get_sq_name()}" => $this->get_sq_value()]);
    }

    private function get_sq_name(): string
    {
        return "SQ_" . substr($this->table, 3);
    }

    private function get_sq_value()
    {
        $get_sq = "get_" . strtolower($this->get_sq_name());

        try {
            return $this->$get_sq();
        } catch (\Throwable $th) {
            return null;
        }
    }

    private function get_binds(): string
    {
        foreach ($this->columns as $column) {
            $method_name = "get_{strtolower($column)}";

            array_push($this->binds, [":{$column}" => $this->$method_name()]);
        }

        return join(", ", $this->binds);
    }
}