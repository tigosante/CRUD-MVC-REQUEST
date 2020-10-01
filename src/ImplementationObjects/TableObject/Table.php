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

  private static $instance;

  /**
   * Referência do objeto filho.
   *
   * @var object $object
   */
  private $object;

  /**
   * Campos a serem ignorados.
   *
   * @var array $ignore
   */
  private $ignoreFields = array(self::ACAO);

  /**
   * Dados que serão usados no DB.
   *
   * @var array $dataToTableObject
   */
  private $dataToTableObject = array();

  /**
   * Objeto com métodos refentes à uma query select.
   *
   * @var QuerySqlInterface $querySqlInterface
   */
  private $querySqlInterface;

  /**
   * Objeto responsável por contruir as querys (QueryBuilder).
   *
   * @var QuerySqlStringInterface $querySqlStringInterface
   */
  private $querySqlStringInterface;

  /**
   * Objeto que contem as informações da tabela que o objeto filho ($object) represente.
   *
   * @var TableInfoInterface $tableInfoInterface
   */
  private $tableInfoInterface;

  /**
   * Objeto responsável por Buscar, atualizar e remover informações o DB.
   *
   * @var DataDBInterface $dataDBInterface
   */
  private $dataDBInterface;

  /**
   * Objeto responsável por maniplar os dados do DB.
   *
   * @var RepositoryDataDBInterface $repositoryDataDBInterface
   */
  private $repositoryDataDBInterface;

  /**
   * Objeto responsavel por criar registros no DB.
   *
   * @var CreateDataDBInterface $createDataDBInterface
   */
  private $createDataDBInterface;

  /**
   * Objeto responsável por buscar 1 registro específico dentro do DB.
   *
   * @var FindDataInterface $findDataInterface
   */
  private $findDataInterface;

  /**
   * Objeto responsável por buscar vários registros dentro do DB.
   *
   * @var FindAllDataInterface $findAllDataInterface
   */
  private $findAllDataInterface;

  /**
   * Objeto responsável por buscar dados, com quantidade reduzida para paginação, no DB.
   *
   * @var PaginationInterface $paginationInterface
   */
  private $paginationInterface;

  /**
   * Configura o objeto pai injetando o que é preciso para tudo funcionar.
   *
   * @param object &$object : Deve conter o objeto filho. (passar o $this do objeto que está extendendo o Table).
   * @param array $tableConfiguration : deve conter um array com as informações da tabela que o objeto filho representa.
   *
   * @return void
   */
  public function __construct(object &$object, array $tableConfiguration)
  {
    $this->object = $object;

    $this->setTableConfiguration($tableConfiguration);
    $this->initObjects();
  }

  /**
   * Retorna uma única instâmcia de um objeto.
   *
   * @param array $args = null; parâmetros que podem ser injetados no objeto.
   *
   * @return self
   */
  public static function singleton(array $args = null): self
  {
    $classCalled = get_called_class();

    if (!isset(self::$instance) && $classCalled) {
      self::$instance = empty($args) ? new $classCalled() : new $classCalled($args);
    }

    return self::$instance;
  }

  /**
   * Método auxiliar para setar dados no objeto atual.
   *
   * @param array $dataArray : deve conter um array com chave e valor.
   * @param bool $isDataToTableDataBase : informa se os dados devem ser carregados para uso no banco de dados.
   * @param bool $isIgnore = false : informa se o método deve usar os valores no array $ignore.

   * @return bool
   */
  private function setDataObject(array $dataArray, bool $isDataToTableDataBase, bool $isIgnore = false): bool
  {
    $result = true;

    try {
      foreach ($dataArray as $key => $value) {
        $method = "set_" . strtolower($key);

        $isNoIgnoreLoop = $isIgnore ? in_array($key, $this->ignoreFields) : $isIgnore;

        if ($isNoIgnoreLoop && method_exists($this->object, $method) && $value !== null) {
          $this->object->$method($value);

          if ($isDataToTableDataBase) {
            $this->dataToTableObject[strtoupper($key)] = $value;
          }
        }
      }
    } catch (\Throwable $error) {
      $result = false;
      var_dump("Erro ao tentar settar os dados vindos da view:: Error: " . $error->getMessage());
    }

    return $result;
  }

  /**
   * Injeta as informações da tabela referente ao objeo atual.
   *
   * @param array $tableConfiguration : deve conter um array de chave e valor.

   * @return void
   */
  private function setTableConfiguration(array $tableConfiguration): void
  {
    $this->tableInfoInterface->setTableName($tableConfiguration[self::TABLE_NAME]);
    $this->tableInfoInterface->setTableColumns($tableConfiguration[self::TABLE_COLUMNS]);
    $this->tableInfoInterface->setDataBaseName($tableConfiguration[self::DATA_BASE_NAME] ?? self::DATA_BASE_NAME_DEFAULT);
    $this->tableInfoInterface->setTableIdentifier($tableConfiguration[self::TABLE_IDENTIFIER]);
    $this->tableInfoInterface->setTableColumnsDate($tableConfiguration[self::TABLE_COLUMNS_DATE]);
  }

  /**
   * Cria instâncias dos objetos necessários para todos os métodos funcionarem corretamente.
   *
   * @return void
   */
  private function initObjects(): void
  {
    $this->tableInfoInterface = new TableInfo();

    $this->querySqlStringInterface = new QuerySqlString($this->tableInfoInterface);
    $this->repositoryDataDBInterface = new RepositoryDataDB(OracleConnection::singleton());

    $this->querySqlInterface = new QuerySql($this->querySqlStringInterface, $this->repositoryDataDBInterface);
    $this->findAllDataInterface = new FindAllData($this->querySqlStringInterface, $this->repositoryDataDBInterface);
    $this->createDataDBInterface = new CreateDataDB($this->querySqlStringInterface, $this->repositoryDataDBInterface);

    $this->dataDBInterface = new DataDB($this->querySqlStringInterface, $this->tableInfoInterface, $this->repositoryDataDBInterface);
    $this->findDataInterface = new FindData($this->querySqlStringInterface, $this->tableInfoInterface, $this->repositoryDataDBInterface);

    $this->paginationInterface = new Pagination($this->querySqlInterface, $this->findAllDataInterface);
  }

  /**
   * Injeta no objeto atual os valores vindos da view.
   *
   * @param bool $isDataToTableDataBase = false : informa se os dados devem ser carregados para uso no banco de dados.

   * @return bool
   */
  public function setAllData(bool $isDataToTableDataBase = true): bool
  {
    $result = $this->setDataObject($_REQUEST, $isDataToTableDataBase, true);

    if ($result && $isDataToTableDataBase) {
      $this->setData($this->dataToTableObject);
    }

    return $result;
  }

  /**
   * Injeta no objeto atual os valores informados.
   *
   * @param array $dataArray : deve conter um com chave e valor.
   * @param bool $isDataToTableDataBase = false : informa se os dados devem ser carregados para uso no banco de dados.

   * @return bool
   */
  public function setDataFromArray(array $dataArray, bool $isDataToTableDataBase = false): bool
  {
    $result = $this->setDataObject($dataArray, $isDataToTableDataBase);

    if ($result && $isDataToTableDataBase) {
      $this->setData($this->dataToTableObject);
    }

    return $result;
  }

  /**
   * Cria e retorna um array contendo cópias do objeto atual carregado com os dados informados.
   *
   * @param array $dataArray : deve conter um array, de array's com chave e valor.

   * @return array
   */
  public function getArrayObjectFromDB(array $dataArray): array
  {
    $arrayObject = array();

    foreach ($dataArray as $valueOfArray) {
      foreach ($valueOfArray as $key => $value) {
        $method = "set_" . strtolower(trim($key));

        if (method_exists($this->object, $method) && $value !== null) {
          $this->object->$method($value);
        }
      }

      array_push($arrayObject, clone $this->object);
    }

    return $arrayObject;
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
      $this->ignoreFields = array_merge($ignore, self::ACAO);
    } elseif ($isAddInArray) {
      $this->ignoreFields = array_merge($this->ignoreFields, $ignore);
    }
  }

  /**
   * Redefine o array de ignoreFields adicionando"acao".
   *
   * @return void
   */
  public function resetIgnoreViewField(): void
  {
    $this->ignoreFields = array(self::ACAO);
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
    return $this->querySqlInterface;
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
    $this->dataDBInterface->where($conditions);
    return $this->dataDBInterface;
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
    return $this->createDataDBInterface->create($tableColumns);
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
    return $this->findDataInterface->find($tableIdentifier, $tableColumns);
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
    return $this->dataDBInterface->findAll($tableColumns);
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
    return $this->paginationInterface->init($paginationInit)->amount($paginationAmount)->end($paginationEnd);
  }

  /**
   * Retorna os dados injetados para uso no DB.
   *
   * @return array
   */
  public function getData(): array
  {
    return $this->repositoryDataDBInterface->getData();
  }

  /**
   * Injeta os dados que serão usados no DB.
   * Por padrão os valores são ajustados para o formato ':CAMPO', não necessitando que o dev use o operador ':' para binds.
   *
   * @param array $data : deve conter um array de chave e valor que será usado no DB.
   *
   * @return void
   */
  public function setData(array $data): void
  {
    $this->repositoryDataDBInterface->setData($data);
  }

  /**
   * Limpa os dados injetados para uso no DB.
   *
   * @return void
   */
  public function clean(): void
  {
    $this->dataToTableObject = [];
    $this->querySqlInterface->clean();
    $this->repositoryDataDBInterface->clean();
  }
}
