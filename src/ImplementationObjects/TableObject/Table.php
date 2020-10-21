<?php

namespace src\TableObject;

use src\Connections\OracleConnection;
use src\interfaces\{
  Audit\AuditInterface,
  DataDB\DataDBInterface,
  DataDB\FindDataInterface,
  QuerySql\QuerySqlInterface,
  TableObject\TableInterface,
  DataDB\CreateDataDBInterface,
  TableObject\TableInfoInterface,
  Pagination\PaginationInterface,
  DataObject\DataObjectInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface,
};
use src\ImplementationObjects\{
  DataDB\DataDB,
  DataDB\FindData,
  DataDB\FindAllData,
  DataDB\CreateDataDB,
  DataDB\FindAllDataInterface,
  QuerySql\QuerySql,
  QuerySql\QuerySqlString,
  TableObject\TableInfo,
  Pagination\Pagination,
  DataObject\DataObject,
  Repository\RepositoryDataDB,
};

class Table implements TableInterface
{
  public const ACAO = "acao";
  public const TABLE_NAME = "tableName";
  public const TABLE_COLUMNS = "tableColumns";
  public const DATA_BASE_NAME = "dataBaseName";
  public const TABLE_IDENTIFIER = "tableIdentifier";
  public const TABLE_COLUMNS_DATE = "tableColumnsDate";
  public const DATA_BASE_NAME_DEFAULT = "PPC.";

  public const DATA_DB = "DATA_DB";
  public const QUERY_SQL = "QUERY_SQL";
  public const FIND_DATA = "FIND_DATA";
  public const TABLE_INFO = "TABLE_INFO";
  public const PAGINATION = "PAGINATION";
  public const FIND_ALL_DATA = "FIND_ALL_DATA";
  public const CREATE_DATA_DB = "CREATE_DATA_DB";
  public const QUERY_SQL_STRING = "QUERY_SQL_STRING";
  public const REPOSITORY_DATA_DB = "REPOSITORY_DATA_DB";
  public const DATA_BASE_CONNECTION = "DATA_BASE_CONNECTION";

  /**
   * Referência do objeto filho.
   *
   * @var object $object
   */
  private static $object;

  /**
   * Campos a serem ignorados.
   *
   * @var array $ignore
   */
  private static $ignoreFields = array(self::ACAO);

  /**
   * Dados que serão usados no DB.
   *
   * @var array $dataToTableObject
   */
  private static $dataToTableObject = array();

  /**
   * @var DataObjectInterface $dataObject
   */
  private static $dataObject;

  /**
   * @var AuditInterface $audit
   */
  private $audit;

  /**
   * Objeto com métodos refentes à uma query select.
   *
   * @var QuerySqlInterface $querySql
   */
  private static $querySql;

  /**
   * Objeto responsável por contruir as querys (QueryBuilder).
   *
   * @var QuerySqlStringInterface $querySqlString
   */
  private static $querySqlString;

  /**
   * Objeto que contem as informações da tabela que o objeto filho ($object) represente.
   *
   * @var TableInfoInterface $tableInfo
   */
  private static $tableInfo;

  /**
   * Objeto responsável por Buscar, atualizar e remover informações o DB.
   *
   * @var DataDBInterface $dataDB
   */
  private static $dataDB;

  /**
   * Objeto responsável por maniplar os dados do DB.
   *
   * @var RepositoryDataDBInterface $repositoryDataDB
   */
  private static $repositoryDataDB;

  /**
   * Objeto responsavel por criar registros no DB.
   *
   * @var CreateDataDBInterface $createDataDB
   */
  private static $createDataDB;

  /**
   * Objeto responsável por buscar 1 registro específico dentro do DB.
   *
   * @var FindDataInterface $findData
   */
  private static $findData;

  /**
   * Objeto responsável por buscar vários registros dentro do DB.
   *
   * @var FindAllDataInterface $findAllData
   */
  private static $findAllData;

  /**
   * Objeto responsável por buscar dados, com quantidade reduzida para paginação, no DB.
   *
   * @var PaginationInterface $pagination
   */
  private static $pagination;

  /**
   * @var bool $useRequest
   */
  private $useRequest = true;

  /**
   * Injeta as informações da tabela referente ao objeo atual.
   *
   * @param array $tableConfiguration : deve conter um array de chave e valor.

   * @return void
   */
  private static function setTableConfiguration(array $tableConfiguration): void
  {
    self::$tableInfo->setTableName($tableConfiguration[self::TABLE_NAME]);
    self::$tableInfo->setTableColumns($tableConfiguration[self::TABLE_COLUMNS]);
    self::$tableInfo->setDataBaseName($tableConfiguration[self::DATA_BASE_NAME] ?? self::DATA_BASE_NAME_DEFAULT);
    self::$tableInfo->setTableIdentifier($tableConfiguration[self::TABLE_IDENTIFIER]);
  }

  /**
   * Cria instâncias dos objetos necessários para todos os métodos funcionarem corretamente.
   *
   * @return void
   */
  private static function initObjects(): void
  {
    self::$tableInfo = new TableInfo;
    self::$dataObject = DataObject::config(self::$object);

    self::$querySqlString = QuerySqlString::config(self::$tableInfo);
    self::$repositoryDataDB = RepositoryDataDB::config(OracleConnection::singleton());

    self::$querySql = QuerySql::config(self::$querySqlString, self::$repositoryDataDB);
    self::$findAllData = FindAllData::config(self::$querySqlString, self::$repositoryDataDB);
    self::$createDataDB = CreateDataDB::config(self::$dataObject, self::$querySqlString, self::$repositoryDataDB);

    self::$dataDB = DataDB::config(self::$dataObject, self::$querySqlString, self::$tableInfo, self::$repositoryDataDB);
    self::$findData = FindData::config(self::$querySqlString, self::$tableInfo, self::$repositoryDataDB);

    self::$pagination = Pagination::config(self::$querySql, self::$findAllData);
  }

  private function removeIgnores(array $data): array
  {
    foreach (self::$ignoreFields as $key => $value) {
      if (in_array($key, $data)) {
        unset($data[$key]);
      }
    }

    return $data;
  }

  /**
   * Configura o objeto pai injetando o que é preciso para tudo funcionar.
   *
   * @param object &$object : Deve conter o objeto filho. (passar o $this do objeto que está extendendo o Table).
   * @param array $tableConfiguration : deve conter um array com as informações da tabela que o objeto filho representa.
   *
   * @return void
   */
  public static function config(object &$object, array $tableConfiguration): void
  {
    self::$object = $object;

    self::setTableConfiguration($tableConfiguration);
    self::initObjects();
  }

  /**
   * @param bool $use = true
   *
   * @return void
   */
  public function useRequest(bool $useRequest = true): void
  {
    $this->useRequest = $useRequest;
  }

  /**
   * Retorna os dados injetados para uso no DB.
   *
   * @var bool $useREQUEST = true : Informa se os dados do $_REQUEST devem ser enviados juntos.
   *
   * @return array
   */
  public function getAllData(bool $useREQUEST = true): array
  {
    return $useREQUEST ? array_merge(self::$repositoryDataDB->getData(), $this->removeIgnores($_REQUEST)) : (self::$repositoryDataDB->getData());
  }

  /**
   * Injeta no objeto atual os valores vindos da view.
   *
   * @param array $data = true : Deve receber um array de chave e valor: array("FIELD" => "value").
   * @param bool $useRequest = true : Faz merge com os dados do $_REQUEST.

   * @return bool
   */
  public function setAllData(array $data = null, bool $useRequest = true): bool
  {
    $result = true;

    if (empty($data)) {
      $data = $_REQUEST;
    } else if ($useRequest) {
      $data = array_merge($_REQUEST, $data);
    }

    try {
      foreach ($data as $key => $value) {
        $method = "set_" . strtolower($key);

        $isNoIgnoreLoop = in_array($key, self::$ignoreFields);

        if ($isNoIgnoreLoop && method_exists(self::$object, $method) && $value !== null) {
          self::$object->$method($value);
          self::$dataToTableObject[strtoupper($key)] = $value;
        }
      }
    } catch (\Throwable $error) {
      $result = false;
      var_dump("Erro ao tentar settar os dados vindos da view:: Error: " . $error->getMessage());
    }

    if ($result) {
      self::$repositoryDataDB->setData(self::$dataToTableObject);
    }

    return $result;
  }

  /**
   * Adiciona campos vindos da view que serão ignorados ao usar o os métodos  setAllData e setDataFromArray.
   *
   * @param array $ignore = null : deve conter um array com os campos vindos da view que serão ignorados.
   * @param bool $isAddInArray = false : informa se os valores passados deve ser adicionados ou escritos como novos.
   *
   * @return void
   */
  public function ignoreViewField(array $ignore, bool $isAddInArray = false): void
  {
    if (!empty($ignore) && $isAddInArray === false) {
      self::$ignoreFields = array_merge($ignore, self::ACAO);
    } elseif ($isAddInArray) {
      self::$ignoreFields = array_merge(self::$ignoreFields, $ignore);
    }
  }

  /**
   * Redefine o array de ignoreFields adicionando"acao".
   *
   * @return void
   */
  public function resetIgnoreViewField(): void
  {
    self::$ignoreFields = array(self::ACAO);
  }

  /**
   * Inicial uma query de busca de dados no DB.
   *
   * @param array $tableColumns = null : deve conter um array com os nomes das colunas desejadas.
   *
   * @return QuerySqlInterface
   */
  public function select(array $tableColumns = null): QuerySqlInterface
  {
    return self::$querySql;
  }

  /**
   * Cria uma condicional para o uso dos métodos delete, update e findAll.
   *
   * @param string $conditions : deve conter uma condicional válida.
   *
   * @return DataDBInterface
   */
  public function where(string $conditions): DataDBInterface
  {
    if ($this->useRequest) {
      $this->setAllData();
    }

    self::$dataDB->where($conditions);

    return self::$dataDB;
  }

  /**
   * @return self
   */
  public function audit(bool $makeAudit = true): self
  {
    $this->audit->makeAudit($makeAudit);
    return $this;
  }

  /**
   * Cria um registro novo dentro de uma determinada tabela no DB.
   *
   * @param array $tableColumns = null : deve conter um array com os nomes das colunas desejadas.
   *
   * @return bool
   */
  public function create(array $tableColumns = null): bool
  {
    if ($this->useRequest) {
      $this->setAllData();
    }

    return self::$createDataDB->create($tableColumns);
  }

  /**
   * Busca um único registro de uma tabela no DB.
   *
   * @param int $tableIdentifier : deve conter um número identificador maior que 0
   * @param array $tableColumns = null : deve conter um array com os nomes das colunas desejadas.
   *
   * @return array
   */
  public function find(int $tableIdentifier, array $tableColumns = null): array
  {
    return self::$findData->find($tableIdentifier, $tableColumns);
  }


  /**
   * Busca todos os registros de uma tabela no DB.
   *
   * @param array $tableColumns = null : deve conter um array com os nomes das colunas desejadas.
   *
   * @return array
   */
  public function findAll(array $tableColumns = null): array
  {
    return self::$dataDB->findAll($tableColumns);
  }

  /**
   * Inicia uma query que retorna dados reduzidos para paginação.
   * Por padrão os parâmetros já contêm valores iniciais: paginationInit: 0, paginationAmount: 15 e paginationEnd: 15.
   *
   * @param int $paginationInit = null : deve conter número do índice inicial da paginação.
   * @param int $paginationAmount = null : deve conter a quantidade de elementos por página.
   * @param int $paginationEnd = null : deve conter número do índice final da paginação.
   *
   * @return PaginationInterface
   */
  public function pagination(int $paginationInit = null, int $paginationAmount = null, int $paginationEnd = null): PaginationInterface
  {
    return self::$pagination
      ->init($paginationInit)
      ->amount($paginationAmount)
      ->end($paginationEnd);
  }

  /**
   * Limpa os dados injetados para uso no DB.
   *
   * @return void
   */
  public function clean(): void
  {
    self::$dataToTableObject = array();
    self::$querySql->clean();
    self::$repositoryDataDB->clean();
  }
}
