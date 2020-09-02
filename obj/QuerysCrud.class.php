<?php

namespace core\OBJECT_CRUD\QUERYS;

use core\OBJECT_CRUD\QUERYS\QueryCrudData;
use core\OBJECT_CRUD\INTERFACES\QueryCrudInterface;

class QuerysCrud extends QueryCrudData implements QueryCrudInterface
{
    /**
     * @return string
     */
    public function insert(): string
    {
        $columnsInsert = join(", ", $this->getColumns());
        $columnsInsertBind = join(", :", $this->getColumns());
        $dataBaseTableName = $this->getDataBaseName() . $this->getTableName();

        return "INSERT INTO {$dataBaseTableName} ({$columnsInsert}) VALUES ({$columnsInsertBind})";
    }

    /**
     * @return string
     */
    public function select(): string
    {
        $columnsSelect = join(", ", $this->getColumns());
        $dataBaseTableName = $this->getDataBaseName() . $this->getTableName();

        return "SELECT {$columnsSelect} FROM {$dataBaseTableName}";
    }

    /**
     * @return string
     */
    public function update(): string
    {
        $columnsBinds = $this->getColumnsUpdate();
        $dataBaseTableName = $this->getDataBaseName() . $this->getTableName();

        return "UPDATE {$dataBaseTableName} SET {$columnsBinds}";
    }

    /**
     * @return string
     */
    public function delete(): string
    {
        return "DELETE " . $this->getDataBaseName() . $this->getTableName();
    }
}
