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
use core\Interfaces\Connections\DataBaseConnectionInterface;
use core\Interfaces\DataDB\FindAllDataInterface;
use core\SimpleORM\{
  DataDB\DataDB,
  DataDB\FindData,
  DataDB\FindAllData,
  DataDB\CreateDataDB,
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
  private $object;

  /**
   * Campos a serem ignorados.
   *
   * @var array $ignore
   */
  private $ignore = array(self::ACAO);

  /**
   * Dados que serão usados no DB.
   *
   * @var array $dataToTableObject
   */
  private $dataToTableObject;

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

  public function __construct()
  {
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

        $isIgnoreLoop = $isIgnore ? in_array($key, $this->ignore) : $isIgnore;

        if ($isIgnoreLoop && method_exists($this->object, $method) && $value !== null) {
          $this->object->$method($value);

          if ($isDataToTableDataBase) {
            $key = ":" . strtoupper($key);
            array_push($this->dataToTableObject, [$key => $value]);
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
  private function setObjects(array $objectsConfiguration = array()): void
  {
    $this->dataBaseConnectionInterface = $objectsConfiguration[self::DATA_BASE_CONNECTION] instanceof DataBaseConnectionInterface ? $objectsConfiguration[self::DATA_BASE_CONNECTION] : new OracleConnection;

    $this->querySqlStringInterface = $objectsConfiguration[self::QUERY_SQL_STRING] instanceof QuerySqlStringInterface ? $objectsConfiguration[self::QUERY_SQL_STRING] : new QuerySqlString($this->tableInfoInterface);
    $this->repositoryDataDBInterface = $objectsConfiguration[self::REPOSITORY_DATA_DB] instanceof RepositoryDataDBInterface ? $objectsConfiguration[self::REPOSITORY_DATA_DB] : new RepositoryDataDB($this->dataBaseConnectionInterface);

    $this->dataDBInterface = $objectsConfiguration[self::DATA_DB] instanceof DataDBInterface ? $objectsConfiguration[self::DATA_DB] : new DataDB($this->querySqlStringInterface, $this->repositoryDataDBInterface);
    $this->querySqlInterface = $objectsConfiguration[self::DATA_BASE_CONNECTION] instanceof DataBaseConnectionInterface ? $objectsConfiguration[self::DATA_BASE_CONNECTION] : new QuerySql($this->querySqlStringInterface, $this->repositoryDataDBInterface);
    $this->findDataInterface = $objectsConfiguration[self::FIND_DATA] instanceof FindDataInterface ? $objectsConfiguration[self::FIND_DATA] : new FindData($this->querySqlStringInterface, $this->repositoryDataDBInterface);
    $this->findAllDataInterface = $objectsConfiguration[self::FIND_ALL_DATA] instanceof FindAllDataInterface ? $objectsConfiguration[self::FIND_ALL_DATA] : new FindAllData($this->querySqlStringInterface, $this->repositoryDataDBInterface);
    $this->createDataDBInterface = $objectsConfiguration[self::CREATE_DATA_DB] instanceof CreateDataDBInterface ? $objectsConfiguration[self::CREATE_DATA_DB] : new CreateDataDB($this->querySqlStringInterface, $this->repositoryDataDBInterface);

    $this->paginationInterface = $objectsConfiguration[self::PAGINATION] instanceof PaginationInterface ? $objectsConfiguration[self::PAGINATION] : new Pagination($this->querySqlInterface, $this->findAllDataInterface);
  }

  /**
   * Configura o objeto pai injetando o que é preciso para tudo funcionar.
   *
   * @param object &$object : Deve conter o objeto filho. (passar o $this do objeto que está extendendo o Table).
   * @param array $tableConfiguration : deve conter um array com as informações da tabela que o objeto filho representa.
   * @param array $objectsConfiguration = array() : [optional] deve conter a instância dos objetos que o dev deseja usar.
   *
   * @return void
   */
  public function configuration(object &$object, array $tableConfiguration, array $objectsConfiguration = array()): void
  {
    $this->object = $object;
    $this->tableInfoInterface[self::TABLE_INFO] instanceof TableInfoInterface ? $objectsConfiguration[self::PAGINATION] : new TableInfo;

    $this->setTableConfiguration($tableConfiguration);
    $this->setObjects($objectsConfiguration);
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

  /**
   * Adiciona campos vindos da view que serão ignorados ao usar o os métodos  setAllData e setDataFromArray.
   *
   * @param array $ignore = null : deve conter um array com os campos vindos da view que serão ignorados.
   * @param bool $isAddInArray = false : informa se os valores passados deve ser adicionados ou escritos como novos.
   *
   * @return void
   */
  public function ignoreViewField(array $ignore = null, bool $isAddInArray = false): void
  {
    $actionArray = array(self::ACAO);

    if (empty($ignore)) {
      $this->ignore = $actionArray;
    } elseif (!(empty($ignore)) && $isAddInArray === false) {
      $this->ignore = array_merge($ignore, $actionArray);
    } elseif ($isAddInArray) {
      array_merge($this->ignore, $ignore);
    }
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
  public function getData(): ?array
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

  /**
   * @param int $fetch_style = null
   * [optional]
   *
   * Controla o conteúdo da matriz retornada no método find, findAll e select. Valor Padrão: PDO::FETCH_ASSOC
   *
   * Para retornar uma matriz que consiste em todos os valores de uma única coluna do conjunto de resultados, use PDO::FETCH_COLUMN. Você pode especificar qual coluna deseja com o parâmetro de índice de coluna.
   *
   * Para buscar apenas os valores únicos de uma única coluna do conjunto de resultados, bit a bit-OR PDO::FETCH_COLUMN with PDO::FETCH_UNIQUE.
   *
   * Para retornar uma matriz associativa agrupada pelos valores de uma coluna especificada, bit a bit-OR PDO::FETCH_COLUMN with PDO::FETCH_GROUP.
   *
   * @param mixed $fetch_argument = null
   * [optional]
   *
   * Este argumento tem um significado diferente dependendo do valor do parâmetro fetch_style:
   *
   * PDO::FETCH_COLUMN: Retorna a coluna indicada com índice 0.
   *
   * @param array $ctor_args = array()
   * [optional]
   *
   * Argumentos do construtor de classe personalizada quando o parâmetro fetch_style é PDO :: FETCH_CLASS.
   *
   * @return void
   */
  public function fetchAllConfiguration(int $fetch_style = null, $fetch_argument = null, array $ctor_args = array()): void
  {
    $this->repositoryDataDBInterface->fetchAllConfiguration($fetch_style, $fetch_argument, $ctor_args);
  }
}
