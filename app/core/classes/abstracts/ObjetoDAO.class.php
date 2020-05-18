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

    public function merge($get_data = false, $fetch_method = PDO::FETCH_OBJ): bool
    {
        return empty($this->get_sq_value()) ? $this->create($get_data, $fetch_method) : $this->update();
    }

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

    public function find_by_sq(int $sq_value, $fetch_method = PDO::FETCH_OBJ): array
    {
        $query = "SELECT * FROM {$this->db_name}{$this->table} WHERE {$this->get_sq_name()} = :{$this->get_sq_name()}";
        $data = $this->pdo->prepare($query);
        $data->execute([":{$this->get_sq_name()}" => $sq_value]);

        return $data->fetch($fetch_method);
    }

    public function find_all($fetch_method = PDO::FETCH_OBJ): array
    {
        $query = "SELECT * FROM {$this->db_name}{$this->table}";
        $data = $this->pdo->prepare($query);

        if ($data->execute()) {
            return $data->fetchAll($fetch_method);
        }

        return false;
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

    public function get_last_data($fetch_method = PDO::FETCH_OBJ)
    {
        $query = "SELECT * FROM {$this->db_name}{$this->table} WHERE {$this->get_sq_name()} = (SELECT MAX({$this->get_sq_name()}) FROM {$this->db_name}{$this->table})";
        $data = $this->pdo->prepare($query);

        if ($data->execute()) {
            return $data->fetch($fetch_method);
        }

        return false;
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