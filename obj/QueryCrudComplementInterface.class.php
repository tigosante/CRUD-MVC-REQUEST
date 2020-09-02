<?php

namespace core\OBJECT_CRUD\INTERFACES\QUERY_CRUD;

interface QueryCrudComplementInterface
{
    /**
     * @return string
     */
    public function getJoin(): string;

    /**
     * @return void
     */
    public function setJoin(string $join): void;

    /**
     * @return string
     */
    public function getWhere(): string;

    /**
     * @return void
     */
    public function setWhere(string $condintion): void;

    /**
     * @return string
     */
    public function getGroupBy(): string;

    /**
     * @return void
     */
    public function setGroupBy(array $groupBy): void;

    /**
     * @return string
     */
    public function getOrderBy(): string;

    /**
     * @return void
     */
    public function setOrderBy(array $orderBy): void;

    /**
     * @return string
     */
    public function getOrderByType(): string;

    /**
     * @return void
     */
    public function setOrderByType(string $orderByType): void;
}
