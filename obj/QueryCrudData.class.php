<?php

namespace core\OBJECT_CRUD\QUERYS;

use core\OBJECT_CRUD\INTERFACES\QUERY_CRUD\QueryCrudDataInterface;

abstract class QueryCrudData implements QueryCrudDataInterface
{
    /**
     * @var array $joins
     */
    private $joins = [];

    /**
     * @var array $columns
     */
    private $columns = [];

    /**
     * @var string $tableNmae
     */
    private $tableNmae = "";

    /**
     * @var array $condintions
     */
    private $condintions = [];

    /**
     * @var string $dataBaseName
     */
    private $dataBaseName = "";

    /**
     * @var array $orderBy
     */
    private $orderBy = [];

    /**
     * @var array $groupBy
     */
    private $groupBy = [];

    /**
     * @var string $orderByType
     */
    private $orderByType = "ASC";

    /**
     * @return void
     */
    public function setDataBaseName(string $dataBaseName): void
    {
        $this->dataBaseName = $dataBaseName;
    }

    /**
     * @return void
     */
    public function setTableName(string $tableNmae): void
    {
        $this->tableNmae = $tableNmae;
    }

    /**
     * @return void
     */
    public function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }

    /**
     * @return void
     */
    public function setJoin(string $join): void
    {
        array_push($this->joins, $join);
    }

    /**
     * @return void
     */
    public function setWhere(string $condintion): void
    {
        array_push($this->condintions, $condintion);
    }

    /**
     * @return void
     */
    public function setOrderByType(string $orderByType): void
    {
        $this->orderByType = $orderByType;
    }

    /**
     * @return void
     */
    public function setOrderBy(array $orderBy): void
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return void
     */
    public function setGroupBy(array $groupBy): void
    {
        $this->groupBy = $groupBy;
    }

    /**
     * @return string
     */
    public function getDataBaseName(): string
    {
        return $this->dataBaseName;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableNmae;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return string
     */
    public function getJoin(): string
    {
        return $this->getStringArray("\n", $this->joins);
    }

    /**
     * @return string
     */
    public function getWhere(): string
    {
        $whereCommnad = "";

        if (!(empty($this->groupBy))) {
            $whereCommnad = " WHERE " . $this->getStringArray("\n", $this->condintions);
        }

        return $whereCommnad;
    }

    /**
     * @return string
     */
    public function getGroupBy(): string
    {
        $groupByCommand = "";

        if (!(empty($this->groupBy))) {
            $groupByCommand = " GROUP BY " . $this->getStringArray(", ", $this->groupBy);
        }

        return $groupByCommand;
    }

    /**
     * @return string
     */
    public function getOrderByType(): string
    {
        return $this->orderByType;
    }

    /**
     * @return string
     */
    public function getOrderBy(): string
    {
        $orderByCommand = "";

        if (!(empty($this->groupBy))) {
            $orderByCommand = " ORDER BY " . $this->getStringArray(", ", $this->orderBy) . $this->getOrderByType();
        }

        return $orderByCommand;
    }

    /**
     * @return string
     */
    public function getColumnsUpdate(): string
    {
        $columnsUpdate = array();

        foreach ($this->getColumns() as $column) {
            array_push($columnsUpdate, "{$column} = :{$column}");
        }

        return $this->getStringArray(", ", $columnsUpdate);
    }

    /**
     * @return string
     */
    private function getStringArray(string $separator, array $array): string
    {
        return join($separator, $array);
    }
}
