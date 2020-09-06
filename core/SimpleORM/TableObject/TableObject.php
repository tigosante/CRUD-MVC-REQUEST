<?php

namespace core\TableObject\TableObject;

use core\Connections\OracleConnection;
use core\interfaces\{
  Crud\CrudGetData,
  Crud\CrudGetDataInterface,
  Crud\CrudHandlerData,
  Crud\CrudHandlerDataInterface,
  QueryString\QueryString,
  Repository\RepositoryGetDataInterface,
  SQLCommands\SQLCommandsHelperInterface,
  SQLCommands\SQLCommandsInterface,
  TableObject\TableObjectInterface,
  TableObject\TableObjectHelperInterface
};
use core\SimpleORM\{
  Repository\RepositoryGetData,
  Repository\RepositoryHandlerData,
  SQLCommands\SQLCommands,
  SQLCommands\SQLCommandsHelper,
  TableObject\TableObjectHelper
};

class TableObject implements TableObjectInterface
{
  /**
   * @var object $object
   */
  private $object;

  /**
   * @var TableObjectHelperInterface $tableObjectHelperInterface
   */
  private $tableObjectHelperInterface;

  /**
   * @var SQLCommands $sqlCommands
   */
  private $sqlCommands;

  /**
   * @var SQLCommandsHelperInterface $sqlCommandsHelper
   */
  private $sqlCommandsHelper;

  /**
   * @var DataBaseConnectionInterface $dataBaseConnectionInterface
   */
  private $dataBaseConnectionInterface;

  /**
   * @var RepositoryGetDataInterface $repositoryGetDataInterface
   */
  private $repositoryGetDataInterface;

  /**
   * @var CrudGetDataInterface $crudGetDataInterface
   */
  private $crudGetDataInterface;

  /**
   * @var CrudHandlerDataInterface $crudHandlerDataInterface
   */
  private $crudHandlerDataInterface;

  /**
   * @var QueryStringInterface $queryStringInterface
   */
  private $queryStringInterface;

  /**
   * @var RepositoryHandlerDataInterface $repositoryHandlerDataInterface
   */
  private $repositoryHandlerDataInterface;


  public function __construct(array $tableConfig, object $object)
  {
    $this->object = $object;
    $this->tableObjectHelperInterface = new TableObjectHelper;

    $this->setTableConfig($tableConfig);
    $this->setObjects();
  }

  private function setTableConfig(array $tableConfig): void
  {
    $this->tableObjectHelperInterface->setTableSq($tableConfig["tableSq"]);
    $this->tableObjectHelperInterface->setTableName($tableConfig["tableName"]);
    $this->tableObjectHelperInterface->setTableColumns($tableConfig["tableColumns"]);
    $this->tableObjectHelperInterface->setDataBaseName($tableConfig["dataBaseName"] ?? ".PPC");
  }

  private function setObjects(): void
  {
    $this->dataBaseConnectionInterface = new OracleConnection;

    $this->sqlCommandsHelper = new SQLCommandsHelper($this->tableObjectHelperInterface);
    $this->sqlCommands = new SQLCommands($this->sqlCommandsHelper, $this->repositoryGetDataInterface);

    $this->queryStringInterface = new QueryString($this->tableObjectHelperInterface);

    $this->repositoryGetDataInterface = new RepositoryGetData($this->dataBaseConnectionInterface);
    $this->crudGetDataInterface = new CrudGetData($this->queryStringInterface, $this->repositoryGetDataInterface);

    $this->repositoryHandlerDataInterface = new RepositoryHandlerData($this->dataBaseConnectionInterface);
    $this->crudHandlerDataInterface = new CrudHandlerData($this->queryStringInterface, $this->repositoryHandlerDataInterface);
  }

  public function setAllData(): bool
  {
    $result = true;

    try {
      foreach ($_REQUEST as $key => $value) {
        $method = "set_" . $key;

        if ($key !== "acao" && method_exists($this->object, $method)) {
          $this->object->$method($value);
        }
      }
    } catch (\Throwable $error) {
      $result = false;
      var_dump("Erro ao tentar settar os dados vindos da view:: Error: " . $error->getMessage());
    }

    return $result;
  }
  public function setAllDataFromArray(array $dataArray): bool
  {
    $result = true;

    try {
      foreach ($dataArray as $key => $value) {
        $method = "set_" . strtolower($key);

        if (method_exists($this->object, $method)) {
          $this->object->$method($value);
        }
      }
    } catch (\Throwable $error) {
      $result = false;
      var_dump("Erro ao tentar settar os dados vindos de um array:: Error: " . $error->getMessage());
    }

    return $result;
  }

  public function select(array $tableColumns = null): SQLCommandsInterface
  {
    return $this->sqlCommands;
  }

  public function where(string $conditions): CrudHandlerDataInterface
  {
    return $this->crudHandlerDataInterface;
  }

  public function create(array $tableColumns = null): bool
  {
  }

  public function findAll(array $tableColumns = null): array
  {
    return $this->crudGetDataInterface->findAll($tableColumns);
  }

  public function findBySq(int $tableSq, array $tableColumns = null): array
  {
    return $this->crudGetDataInterface->findBySq($tableSq, $tableColumns);
  }
}
