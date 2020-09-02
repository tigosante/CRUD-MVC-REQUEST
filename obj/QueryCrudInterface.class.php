<?php

namespace core\OBJECT_CRUD\INTERFACES\QUERY_CRUD;

use core\OBJECT_CRUD\INTERFACES\QUERY_CRUD\{
    QueryCrudDataInterface,
    QueryCrudComplementInterface
};

interface QueryCrudInterface extends QueryCrudDataInterface, QueryCrudComplementInterface
{
    /**
     * @return string
     */
    public function insert(): string;

    /**
     * @return string
     */
    public function select(): string;

    /**
     * @return string
     */
    public function update(): string;

    /**
     * @return string
     */
    public function delete(): string;
}
