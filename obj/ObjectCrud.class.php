<?php

namespace core\OBJECT_CRUD;

use core\classes\abstratas\ModelAbstract;
use core\OBJECT_CRUD\HANDLED_DB\HandledDB;
use core\OBJECT_CRUD\INTERFACES\QUERY_CRUD\QueryCrudInterface;

use core\OBJECT_CRUD\QUERYS\{
    QuerysCrud,
    QueryCrudPaginate
};

use core\OBJECT_CRUD\INTERFACES\{
    HandledDBInterface,
    QueryCrudPaginateInterface
};

abstract class ObjectCrud extends ModelAbstract
{
    /**
     * @var HandledDBInterface $handledDB
     */
    private $handledDB;

    /**
     * @var QueryCrudInterface $querysCrud
     */
    private $querysCrud;

    /**
     * @var QueryCrudPaginateInterface $queryCrudPagination
     */
    private $queryCrudPagination;

    /**
     * @var array $columnsKeys
     */
    private $columnsKeys = [];

    /**
     * @var array $columns
     */
    private $columns = [];

    /**
     * @var int $identifier
     */
    private $identifier;

    /**
     * @var int $sq
     */
    private $sq = null;

    /**
     * @var bool $isPaginate
     */
    private $isPaginate = false;

    public const HANDLED_DB = "HANDLED_DB";
    public const QUERY_CRUD = "QUERY_CRUD";
    public const QUERY_CRUD_PAGINATION = "QUERY_CRUD_PAGINATION";

    /**
     * @var array $config
     */
    private $config = array(
        self::HANDLED_DB => null,
        self::QUERY_CRUD => null,
        self::QUERY_CRUD_PAGINATION => null
    );

    private const SYSDATE = "SYSDATE";

    public function setConfig(array $config = null): void
    {
        $config = empty($config) ? $this->config : $config;

        $this->handledDB = $config[self::HANDLED_DB] ?? new HandledDB;
        $this->querysCrud = $config[self::QUERY_CRUD] ?? new QuerysCrud;
        $this->queryCrudPagination = $config[self::QUERY_CRUD_PAGINATION] ?? new QueryCrudPaginate;

        $this->config = array(
            self::HANDLED_DB => $this->handledDB,
            self::QUERY_CRUD => $this->querysCrud,
            self::QUERY_CRUD_PAGINATION => $this->queryCrudPagination
        );
    }

    protected function getTableName(): string
    {
        return $this->querysCrud->getTableName();
    }

    protected function setTableName(string $tableName): void
    {
        $this->querysCrud->setTableName($tableName);
    }

    protected function getDataBaseName(): string
    {
        return $this->querysCrud->getDataBaseName();
    }

    protected function setDataBaseName(string $dataBaseName = ".ppc"): void
    {
        $this->querysCrud->setDataBaseName($dataBaseName);
    }

    protected function getColumns(): array
    {
        return $this->columns;
    }

    protected function setColumns(array $columns): void
    {
        $this->columns = $columns;
    }

    protected function setIdentifier(int $identifier): void
    {
        $this->identifier = $identifier;
    }

    protected function getIdentifier(): int
    {
        return $this->identifier;
    }

    protected function findBySq(int $sq, array $columns = null, int $fetchStyle = \PDO::FETCH_ASSOC): array
    {
        $this->sq = $sq;
        $columns = empty($columns) ? $this->getColumns() : $columns;

        $this->setDataColumns(array($this->identifier));
        $this->querysCrud->setColumns($columns);
        $this->querysCrud->setWhere("{$this->identifier} = :{$this->identifier}");

        return $this->fetchAll($fetchStyle);
    }

    protected function findAll(array $columns = null, int $fetchStyle = \PDO::FETCH_ASSOC): array
    {
        $columns = empty($columns) ? $this->getColumns() : $columns;
        $this->querysCrud->setColumns($columns);

        return $this->fetchAll($fetchStyle);
    }

    protected function create(array $columns = null): bool
    {
        if (!(empty($columns))) {
            $this->setDataColumns($columns);
            $this->querysCrud->setColumns($columns);
        }

        return $this->executeCommand($this->querysCrud->insert());
    }

    protected function update(array $columns = null): bool
    {
        if (!(empty($columns))) {
            $this->setDataColumns($columns);
            $this->querysCrud->setColumns($columns);
        }

        return $this->executeCommand($this->querysCrud->update());
    }

    protected function delete(array $conditions = null): bool
    {
        $data = null;

        if (empty($conditions)) {
            $data = array($this->identifier);
            $conditions = "{$this->identifier} = :{$this->identifier}";
        } else {
            $conditions = join(" ", $conditions);
        }

        $this->setDataColumns($data);
        $this->querysCrud->setWhere($conditions);

        return $this->executeCommand($this->querysCrud->delete());
    }

    public function paginate(int $numberPages = null, int $start = null, int $end = null): self
    {
        $this->isPaginate = true;

        if (empty($numberPages)) {
            $this->queryCrudPagination->setNumberPages($numberPages);
        }

        if (empty($start)) {
            $this->queryCrudPagination->setStart($start);
        }

        if (empty($end)) {
            $this->queryCrudPagination->setEnd($end);
        }

        return $this;
    }

    public function select(array $columns): self
    {
        $this->querysCrud->setColumns($columns);
        return $this;
    }

    public function join(string $typeJoin, string $dataBaseTableName, string $conditions): self
    {
        $this->querysCrud->setJoin("   {$typeJoin} JOIN {$dataBaseTableName} {$conditions}");
        return $this;
    }

    public function where(string $conditions): self
    {
        $this->querysCrud->setWhere($conditions);
        return $this;
    }

    public function groupBy(array $columns): self
    {
        $this->querysCrud->setGroupBy($columns);
        return $this;
    }

    public function orderBy(array $columns, string $order = "ASC"): self
    {
        $this->querysCrud->setOrderBy($columns);
        $this->querysCrud->setOrderByType($order);

        return $this;
    }

    public function fetchAll(int $fetchStyle = \PDO::FETCH_ASSOC): array
    {
        $data = null;
        $query = $this->getQueryString();


        if ($this->sq !== null) {
            $data = array(":{$this->identifier}" => $this->sq);
        }

        if ($this->isPaginate) {
            $query = $this->queryCrudPagination->getSelectPaginate($query);
            $data = $this->queryCrudPagination->getbindsWithPagination($data);
        }

        $this->handledDB->setQuery($query);
        $this->handledDB->setData($data);
        $dataDataBase = $this->handledDB->getDataQuery($fetchStyle);

        return $this->isPaginate ? $this->queryCrudPagination->adjustData($dataDataBase) : $dataDataBase;
    }

    public function getQueryString(): string
    {
        return $this->querysCrud->select()
            . $this->querysCrud->getJoin()
            . $this->querysCrud->getWhere()
            . $this->querysCrud->getGroupBy()
            . $this->querysCrud->getOrderBy();
    }

    private function executeCommand(string $command): bool
    {
        $this->handledDB->setQuery($command);
        $this->handledDB->setData($this->columnsKeys);

        return $this->handledDB->executeQuery();
    }

    private function setDataColumns(array $columnsKeys = null): void
    {
        $columnsKeys = empty($columnsKeys) ? $this->getColumns() : $columnsKeys;

        foreach ($columnsKeys as $column) {
            $method = "get_" . strtolower($column);
            $data = $method();

            if ($data !== null) {
                if (substr(strtoupper($column), 0, 3) == "DT_" && $data != self::SYSDATE) {
                    $this->columnsKeys[$column] = "TO_DATE({$data}, 'DD/MM/YYYY')";
                } else if ($data != self::SYSDATE) {
                    $this->columnsKeys[$column] = $data;
                }
            }
        }
    }
}
