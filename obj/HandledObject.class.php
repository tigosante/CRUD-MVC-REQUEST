<?php

namespace core\OBJECT_CRUD\HANDLED_OBJECT;

use core\OBJECT_CRUD\QUERYS\QuerysCrud;
use core\OBJECT_CRUD\DTOS\TableDTOInterface;

class HandledObject
{
    /**
     * @var TableDTOInterface $object
     */
    private $object;

    /**
     * @var QuerysCrud $queryCrud
     */
    private $queryCrud;

    public function __construct()
    {
        $this->queryCrud = new QuerysCrud;
    }

    /**
     * @return void
     */
    public function setObject(TableDTOInterface $object): void
    {
        $this->object = $object;
    }

    /**
     * @return void
     */
    public function loadData(): void
    {
        $this->queryCrud->setColumns($this->object->getColumns());
        $this->queryCrud->setTableName($this->object->getTableName());
        $this->queryCrud->setDataBasename($this->object->getDataBasename());
    }

    /**
     * @return void
     */
    public function getQuery(string $typeQuery): string
    {
        return $this->queryCrud->$typeQuery();
    }
}
