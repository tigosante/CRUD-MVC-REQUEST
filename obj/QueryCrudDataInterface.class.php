<?php

namespace core\OBJECT_CRUD\INTERFACES\QUERY_CRUD;

interface QueryCrudDataInterface
{
    /**
     * @return string
     */
    public function getTableName(): string;

    /**
     * @return void
     */
    public function setTableName(string $tableNmae): void;

    /**
     * @return string
     */
    public function getDataBaseName(): string;

    /**
     * @return void
     */
    public function setDataBaseName(string $dataBaseName): void;

    /**
     * @return string
     */
    public function getColumns(): array;

    /**
     * @return void
     */
    public function setColumns(array $columns): void;
}
