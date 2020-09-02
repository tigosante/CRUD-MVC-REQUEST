<?php

namespace core\OBJECT_CRUD\HANDLED_DB;

abstract class HandledDbData
{
    /**
     * @var \PDO $connection
     */
    private $connection = null;

    /**
     * @var string $query
     */
    private $query = "";

    /**
     * @var array $data
     */
    private $data = null;

    /**
     * @param \PDO $connection
     * @return void
     */
    public function setConnection(\PDO $connection): void
    {
        $this->connection = $connection;
    }

    /**
     * @return \PDO
     */
    public function getConnection(): \PDO
    {
        return $this->connection;
    }

    /**
     * @param string $query
     * @return void
     */
    public function setQuery(string $query): void
    {
        $this->query = $query;
    }


    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param array $data
     * @return void
     */
    public function setData(array $data = null): void
    {
        $this->data = $data;
    }

    /**
     * @return array|null
     */
    public function getData()
    {
        return $this->data;
    }
}
