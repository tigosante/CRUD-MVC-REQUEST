<?php

namespace core\TableObject;

use core\Connections\OracleConnection;
use core\interfaces\{
  DataDB\DataDBInterface,
  DataDB\FindDataInterface,
  DataDB\CreateDataDBInterface,
  QuerySql\QuerySqlInterface,
  QuerySql\QuerySqlStringInterface,
  TableObject\TableInterface,
  TableObject\TableInfoInterface,
  Pagination\PaginationInterface,
  Repository\RepositoryDataDBInterface,
};

use core\SimpleORM\{
  DataDB\DataDB,
  DataDB\CreateDataDB,
  QuerySql\QuerySql,
  QuerySql\QuerySqlString,
  Repository\RepositoryDataDB,
  TableObject\TableInfo
};
use core\SimpleORM\DataDB\FindAllData;
use core\SimpleORM\DataDB\FindData;
use core\SimpleORM\Pagination\Pagination;

class Table implements TableInterface
{
  /**
   * @var object $object
   */
  private $object;

  /**
   * @var array $ignore
   */
  private $ignore = ["acao"];

  /**
   * @var QuerySqlInterface $querySqlInterface
   */
  private $querySqlInterface;

  /**
   * @var TableInfoInterface $tableInfoInterface
   */
  private $tableInfoInterface;

  /**
   * @var DataDBInterface $dataDBInterface
   */
  private $dataDBInterface;

  /**
   * @var QuerySqlStringInterface $querySqlStringInterface
   */
  private $querySqlStringInterface;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDBInterface
   */
  private $repositoryDataDBInterface;

  /**
   * @var CreateDataDBInterface $createDataDBInterface
   */
  private $createDataDBInterface;

  /**
   * @var FindDataInterface $findDataInterface
   */
  private $findDataInterface;

  /**
   * @var FindAllDataInterface $findAllDataInterface
   */
  private $findAllDataInterface;

  /**
   * @var PaginationInterface $paginationInterface
   */
  private $paginationInterface;

  public function __construct(array $tableConfiguration, object &$object)
  {
    $this->object = $object;
    $this->tableInfoInterface = new TableInfo;

    $this->setTableConfiguration($tableConfiguration);
    $this->setObjects();
  }

  private function setTableConfiguration(array $tableConfiguration): void
  {
    $this->tableInfoInterface->setTableName($tableConfiguration["tableName"]);
    $this->tableInfoInterface->setTableColumns($tableConfiguration["tableColumns"]);
    $this->tableInfoInterface->setDataBaseName($tableConfiguration["dataBaseName"] ?? ".PPC");
    $this->tableInfoInterface->setTableIdentifier($tableConfiguration["tableIdentifier"]);
  }

  private function setObjects(): void
  {
    $this->dataBaseConnectionInterface = new OracleConnection;

    $this->querySqlStringInterface = new QuerySqlString($this->tableInfoInterface);
    $this->repositoryDataDBInterface = new RepositoryDataDB($this->dataBaseConnectionInterface);

    $this->dataDBInterface = new DataDB($this->querySqlStringInterface, $this->repositoryDataDBInterface);
    $this->querySqlInterface = new QuerySql($this->querySqlStringInterface, $this->repositoryDataDBInterface);
    $this->findDataInterface = new FindData($this->querySqlStringInterface, $this->repositoryDataDBInterface);
    $this->findAllDataInterface = new FindAllData($this->querySqlStringInterface, $this->repositoryDataDBInterface);
    $this->createDataDBInterface = new CreateDataDB($this->querySqlStringInterface, $this->repositoryDataDBInterface);

    $this->paginationInterface = new Pagination($this->querySqlInterface, $this->findAllDataInterface);
  }

  public function setAllData(bool $isDataToTableDataBase = true): bool
  {
    $result = true;

    try {
      foreach ($_REQUEST as $key => $value) {
        $method = "set_" . $key;

        if (!(in_array($key, $this->ignore)) && method_exists($this->object, $method) && $value !== null) {
          $this->object->$method($value);

          if ($isDataToTableDataBase) {
            array_push($this->dataToTableObject, [strtoupper($key) => $value]);
          }
        }
      }
    } catch (\Throwable $error) {
      $result = false;
      var_dump("Erro ao tentar settar os dados vindos da view:: Error: " . $error->getMessage());
    }

    return $result;
  }

  public function setDataFromArray(array $dataArray, bool $isDataToTableDataBase = true): bool
  {
    $result = true;

    try {
      foreach ($dataArray as $key => $value) {
        $method = "set_" . strtolower($key);

        if (method_exists($this->object, $method) && $value !== null) {
          $this->object->$method($value);

          if ($isDataToTableDataBase) {
            array_push($this->dataToTableObject, [strtoupper($key) => $value]);
          }
        }
      }
    } catch (\Throwable $error) {
      $result = false;
      var_dump("Erro ao tentar settar os dados vindos de um array:: Error: " . $error->getMessage());
    }

    return $result;
  }

  public function getArrayObjectFromDB(array $dataArray): array
  {
    $arrayObject = array();

    foreach ($dataArray as $valueOfArray) {
      foreach ($$valueOfArray as $key => $value) {
        $method = "set_" . strtolower($key);

        if (method_exists($this->object, $method) && $value !== null) {
          $this->object->$method($value);
        }
      }
      array_push($arrayObject, clone $this->object);
    }

    return $arrayObject;
  }

  public function ignoreInArray(array $ignore): void
  {
    array_merge($this->ignore, $ignore);
  }

  public function select(array $tableColumns = null): QuerySqlInterface
  {
    return $this->querySqlInterface;
  }

  public function where(string $conditions): DataDBInterface
  {
    $this->dataDBInterface->where($conditions);
    return $this->dataDBInterface;
  }

  public function create(array $tableColumns = null): bool
  {
    return $this->createDataDBInterface->create($tableColumns);
  }

  public function find(int $tableIdentifier, array $tableColumns = null): array
  {
    return $this->findDataInterface->find($tableIdentifier, $tableColumns);
  }

  public function findAll(array $tableColumns = null): array
  {
    return $this->dataDBInterface->findAll($tableColumns);
  }

  /**
   * Por padrão os parâmetros já contêm valores iniciais: paginationInit: 0, paginationAmount: 15 e paginationEnd: 15
   *
   * @param int $paginationInit = null
   * @param int $paginationAmount = null
   * @param int $paginationEnd = null
   *
   * @return PaginationInterface
   */
  public function pagination(int $paginationInit = null, int $paginationAmount = null, int $paginationEnd = null): PaginationInterface
  {
    return $this->paginationInterface->init($paginationInit)->amount($paginationAmount)->end($paginationEnd);
  }

  public function setData(array $data): void
  {
    $this->repositoryDataDBInterface->setData($data);
  }

  public function clean(): void
  {
    $this->querySqlInterface->clean();
  }
}
