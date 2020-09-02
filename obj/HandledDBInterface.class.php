<?php

namespace core\OBJECT_CRUD\INTERFACES;

interface HandledDBInterface
{
    /**
     * @return bool
     */
    public function executeQuery(): bool;

    /**
     * @return array
     */
    public function getDataQuery(int $fetchStyle = \PDO::FETCH_ASSOC): array;

    /**
     * @return PDO
     */
    public function getConnection(): \PDO;

    /**
     * @return void
     */
    public function setConnection(\PDO $connection): void;

    /**
     * @return string
     */
    public function getQuery(): string;

    /**
     * @return void
     */
    public function setQuery(string $query): void;

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @return void
     */
    public function setData(array $data = null): void;
}
