<?php

namespace core\classes\ORM;

use core\classes\ORM\AUXORM;

abstract class CRUD extends AUXORM
{
    private $query = "";
    private $joins = "";
    private $conditions = "";
    private $query_full = "";

    protected function insert(): object
    {
        $this->query = "INSERT INTO {$this->db_name}{$this->table_name} ({$this->get_columns()})VALUES({$this->get_columns_bind()}) ";

        return $this;
    }

    protected function select(string $columns = "*"): object
    {
        $this->verica_data($columns, "select");
        $this->query = "SELECT {$columns} {$this->db_name}{$this->table_name} WHERE 1=1 ";

        return $this;
    }

    protected function update($sq_value = null, string $operator = "="): object
    {
        $where_update = "";
        if (!empty($sq_value)) {
            $where_update = "{$this->get_sq_name()} {$operator} {$sq_value}";
        }

        $this->query = "UPDATE {$this->db_name}{$this->table_name} SET {$this->get_columns_bind_update()} WHERE 1=1 AND {$where_update} ";

        return $this;
    }

    protected function delete(): object
    {
        $this->query = "DELETE {$this->db_name}{$this->table_name} WHERE 1=1 ";

        return $this;
    }

    protected function join(string $type_join, string $table_name, string $condition, string $db_name = "PPC."): object
    {
        $this->joins .= " {$type_join} JOIN {$db_name}{$table_name} {$condition} ";
        return $this;
    }

    protected function where(string $condition): object
    {
        $this->conditions .= " {$condition} ";
        return $this;
    }

    protected function where_array(array $conditions): object
    {
        foreach ($conditions as $condition) {
            $this->where($condition);
        }

        return $this;
    }

    protected function fetch(\PDO $fetch_method = \PDO::FETCH_OBJ): array
    {
        return $this->get_data_array($fetch_method, "fetch");
    }

    protected function fetch_all(\PDO $fetch_method = \PDO::FETCH_OBJ): array
    {
        return $this->get_data_array($fetch_method, "fetchAll");
    }

    protected function execute(array $binds = []): bool
    {
        $this->prepare_query();
        $stmt = $this->pdo->prepare($this->query_full);

        return  empty($binds) ? $stmt->execute() : $stmt->execute($binds);
    }


    private function prepare_query(): void
    {
        $this->query_full = $this->query . $this->conditions;
    }

    private function get_data_array($fetch_method, string $method_PDO): array
    {
        $this->prepare_query();
        $stmt = $this->pdo->prepare($this->query_full);
        $stmt = $this->execute_validate($stmt);

        if ($stmt->rowCount() > 0) {
            return $method_PDO === "fetch" ? $stmt->fetch($fetch_method) : $stmt->fetchAll($fetch_method);
        }

        return [];
    }

    private function execute_validate($stmt)
    {
        if ($stmt->execute()) {
            return $stmt;
        }

        throw new \InvalidArgumentException("Erro ao executar comando! \nVerifique os dados informados ou o objeto referente a tabela do DB: {$this->db_name}");
    }
}