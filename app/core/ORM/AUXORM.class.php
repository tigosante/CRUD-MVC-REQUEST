<?php

namespace core\classes\ORM;

use core\classes\abstracts\ModelDAO;

abstract class AUXORM extends ModelDAO
{
    protected $db_name = "";
    protected $columns = [];
    protected $table_name = "";

    protected function get_sq_name(): string
    {
        return "SQ_" . substr($this->table_name, 0, 3);
    }

    protected function verica_data($data, string $method): void
    {
        if (empty($data)) {
            throw new \UnexpectedValueException("O dado informado para o método {$method} é inválido.");
        }
    }

    protected function get_columns(string $separator = ", ", array $columns = []): string
    {
        $columns_join = $columns ?? $this->columns;
        return join($separator, $columns_join);
    }

    protected function get_columns_bind(): string
    {
        return ":{$this->get_columns(', :')}";
    }

    protected function get_columns_bind_update(): string
    {
        $binds_update = [];
        foreach ($this->columns as $column) {
            array_push($binds_update, "{$column} = :{$column}");
        }

        return $this->get_columns(", ", $binds_update);
    }
}