<?php

namespace src\TableObject;

use src\Connections\OracleConnection;
use src\interfaces\{
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
   * Objeto com métodos refentes à uma query select.
   *
   * @var QuerySqlInterface $querySqlInterface
   */
  private static $querySqlInterface;

  /**
   * Objeto responsável por contruir as querys (QueryBuilder).
   *
   * @var QuerySqlStringInterface $querySqlStringInterface
   */
  private static $querySqlStringInterface;

  /**
   * Objeto que contem as informações da tabela que o objeto filho ($object) represente.
   *
   * @var TableInfoInterface $tableInfoInterface
   */
  private static $tableInfoInterface;

  /**
   * Objeto responsável por Buscar, atualizar e remover informações o DB.
   *
   * @var DataDBInterface $dataDBInterface
   */
  private static $dataDBInterface;

  /**
   * Objeto responsável por maniplar os dados do DB.
   *
   * @var RepositoryDataDBInterface $repositoryDataDBInterface
   */
  private static $repositoryDataDBInterface;

  /**
   * Objeto responsavel por criar registros no DB.
   *
   * @var CreateDataDBInterface $createDataDBInterface
   */
  private static $createDataDBInterface;

  /**
   * Objeto responsável por buscar 1 registro específico dentro do DB.
   *
   * @var FindDataInterface $findDataInterface
   */
  private static $findDataInterface;

  /**
   * Objeto responsável por buscar vários registros dentro do DB.
   *
   * @var FindAllDataInterface $findAllDataInterface
   */
  private static $findAllDataInterface;

  /**
   * Objeto responsável por buscar dados, com quantidade reduzida para paginação, no DB.
   *
   * @var PaginationInterface $paginationInterface
   */
  private static $paginationInterface;

  /**
   * Injeta as informações da tabela referente ao objeo atual.
   *
   * @param array $tableConfiguration : deve conter um array de chave e valor.

   * @return void
   */
  private static function setTableConfiguration(array $tableConfiguration): void
  {
    self::$tableInfoInterface->setTableName($tableConfiguration[self::TABLE_NAME]);
    self::$tableInfoInterface->setTableColumns($tableConfiguration[self::TABLE_COLUMNS]);
    self::$tableInfoInterface->setDataBaseName($tableConfiguration[self::DATA_BASE_NAME] ?? self::DATA_BASE_NAME_DEFAULT);
    self::$tableInfoInterface->setTableIdentifier($tableConfiguration[self::TABLE_IDENTIFIER]);
    self::$tableInfoInterface->setTableColumnsDate($tableConfiguration[self::TABLE_COLUMNS_DATE]);
  }

  /**
   * Cria instâncias dos objetos necessários para todos os métodos funcionarem corretamente.
   *
   * @return void
   */
  private static function initObjects(): void
  {
    self::$tableInfoInterface = new TableInfo;

    self::$querySqlStringInterface = QuerySqlString::config(self::$tableInfoInterface);
    self::$repositoryDataDBInterface = RepositoryDataDB::config(OracleConnection::singleton());

    self::$querySqlInterface = QuerySql::config(self::$querySqlStringInterface, self::$repositoryDataDBInterface);
    self::$findAllDataInterface = FindAllData::config(self::$querySqlStringInterface, self::$repositoryDataDBInterface);
    self::$createDataDBInterface = CreateDataDB::config(self::$querySqlStringInterface, self::$repositoryDataDBInterface);

    self::$dataDBInterface = DataDB::config(self::$querySqlStringInterface, self::$tableInfoInterface, self::$repositoryDataDBInterface);
    self::$findDataInterface = FindData::config(self::$querySqlStringInterface, self::$tableInfoInterface, self::$repositoryDataDBInterface);

    self::$paginationInterface = Pagination::config(self::$querySqlInterface, self::$findAllDataInterface);
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
   * Retorna os dados injetados para uso no DB.
   *
   * @return array
   */
  public function getAllData(bool $useREQUEST = true): array
  {
    return $useREQUEST ? array_merge(self::$repositoryDataDBInterface->getData(), $this->removeIgnores($_REQUEST)) : self::$repositoryDataDBInterface->getData();
  }

  /**
   * Injeta no objeto atual os valores vindos da view.
   *
   * @param bool $isDataToTableDataBase = false : informa se os dados devem ser carregados para uso no banco de dados.

   * @return bool
   */
  public function setAllData(array $data = null, bool $isDataToTableDataBase = true): bool
  {
    $result = true;
    $data = empty($data) ? $_REQUEST : $data;

    try {
      foreach ($data as $key => $value) {
        $method = "set_" . strtolower($key);

        $isNoIgnoreLoop = in_array($key, self::$ignoreFields);

        if ($isNoIgnoreLoop && method_exists(self::$object, $method) && $value !== null) {
          self::$object->$method($value);

          if ($isDataToTableDataBase) {
            self::$dataToTableObject[strtoupper($key)] = $value;
          }
        }
      }
    } catch (\Throwable $error) {
      $result = false;
      var_dump("Erro ao tentar settar os dados vindos da view:: Error: " . $error->getMessage());
    }

    if ($result && $isDataToTableDataBase) {
      self::$repositoryDataDBInterface->setData(self::$dataToTableObject);
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
    return self::$querySqlInterface;
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
    self::$dataDBInterface->where($conditions);
    return self::$dataDBInterface;
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
    return self::$createDataDBInterface->create($tableColumns);
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
    return self::$findDataInterface->find($tableIdentifier, $tableColumns);
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
    return self::$dataDBInterface->findAll($tableColumns);
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
    return self::$paginationInterface
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
    self::$dataToTableObject = [];
    self::$querySqlInterface->clean();
    self::$repositoryDataDBInterface->clean();
  }
}
