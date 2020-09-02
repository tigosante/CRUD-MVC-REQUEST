<?php

namespace core\OBJECT_CRUD\INTERFACES;

interface QueryCrudPaginateInterface
{
    /**
     * @return int
     */
    public function getNumberPages(): int;

    /**
     * @return void
     */
    public function setNumberPages(int $numberPages): void;

    /**
     * @return int
     */
    public function getStart(): int;

    /**
     * @return void
     */
    public function setStart(int $start): void;

    /**
     * @return int
     */
    public function getEnd(): int;

    /**
     * @return void
     */
    public function setEnd(int $end): void;

    /**
     * @return string
     */
    public function getSelectPaginate(string $query): string;

    /**
     * @return array
     */
    public function getbindsWithPagination(array $data): array;

    /**
     * @return array
     */
    public function adjustData(array $data, string $method = null): array;
}
