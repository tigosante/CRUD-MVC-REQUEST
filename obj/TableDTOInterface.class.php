<?php

namespace core\OBJECT_CRUD\DTOS;

interface TableDTOInterface
{
    public function getColumns(): array;
    public function getTableName(): string;
    public function getDataBasename(): string;
}
