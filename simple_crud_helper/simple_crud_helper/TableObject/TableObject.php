<?php

namespace core\classes\simple_crud_helper\TableObject;

use core\config\ConexaoOracle;


use core\classes\{
  _objetos\AuditoriaONew,
  interfaces\Audit\AuditInterface,
  interfaces\Audit\AuditObjectInterface,
  interfaces\DataDB\DataDBInterface,
  interfaces\DataDB\FindDataInterface,
  interfaces\DataDB\CreateDataDBInterface,
  interfaces\QuerySql\QuerySqlInterface,
  interfaces\QuerySql\QuerySqlStringInterface,
  interfaces\TableObject\TableObjectInterface,
  interfaces\TableObject\TableObjectInfoInterface,
  interfaces\DataObject\DataObjectInterface,
  interfaces\Pagination\PaginationInterface,
  interfaces\Repository\RepositoryDataDBInterface,
  simple_crud_helper\Audit\Audit,
  simple_crud_helper\DataDB\DataDB,
  simple_crud_helper\DataDB\FindData,
  simple_crud_helper\DataDB\FindAllData,
  simple_crud_helper\DataDB\CreateDataDB,
  simple_crud_helper\DataDB\FindAllDataInterface,
  simple_crud_helper\QuerySql\QuerySql,
  simple_crud_helper\QuerySql\QuerySqlString,
  simple_crud_helper\TableObject\TableObjectInfo,
  simple_crud_helper\Pagination\Pagination,
  simple_crud_helper\Repository\RepositoryDataDB,
  simple_crud_helper\DataObject\DataObject
};

class TableObject implements TableObjectInterface
{
  public const ACAO = "acao";
  public const SYSDATE = 'SYSDATE';
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
  private $ignoreFields = array(self::ACAO);

  /**
   * Dados que serão usados no DB.
   *
   * @var array $dataToTableObject
   */
  private $dataToTableObject = array();

  /**
   * @var bool $useRequest
   */
  private $useRequest = true;

  /**
   * @param AuditObjectInterface $auditObject
   */
  private static $auditObject;

  /**
   * @var AuditInterface $audit
   */
  private static $audit;

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
   * @var TableObjectInfoInterface $tableObjectInfo
   */
  private static $tableObjectInfo;

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
   * @var DataObjectInterface $dataObject
   */
  private static $dataObject;

  /**
   * Cria instâncias dos objetos necessários para todos os métodos funcionarem corretamente.
   *
   * @return void
   */
  private function initObjects(): void
  {
    self::$auditObject = new AuditoriaONew;
    self::$audit = (new Audit)->config(self::$auditObject);
    self::$dataObject = DataObject::config(self::$object);

    self::$querySqlString = QuerySqlString::config(self::$tableObjectInfo, self::$dataObject);
    self::$repositoryDataDB = RepositoryDataDB::config(ConexaoOracle::singleton(), self::$audit);

    self::$querySql = QuerySql::config(self::$querySqlString, self::$repositoryDataDB);
    self::$findAllData = FindAllData::config(self::$querySqlString, self::$repositoryDataDB);
    self::$createDataDB = CreateDataDB::config(self::$dataObject, self::$querySqlString, self::$repositoryDataDB);

    self::$dataDB = DataDB::config(self::$dataObject, self::$querySqlString, self::$tableObjectInfo, self::$repositoryDataDB);
    self::$findData = FindData::config(self::$querySqlString, self::$tableObjectInfo, self::$repositoryDataDB);

    self::$pagination = Pagination::config(self::$querySql, self::$findAllData, self::$querySqlString);
  }

  private function removeIgnores(array $data): array
  {
    foreach ($this->ignoreFields as $key => $value) {
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
  public function config(object &$object, array $tableConfiguration)
  {
    self::$object = $object;
    self::$tableObjectInfo = new TableObjectInfo();

    self::$tableObjectInfo->setTableName($tableConfiguration[self::TABLE_NAME]);
    self::$tableObjectInfo->setTableColumns($tableConfiguration[self::TABLE_COLUMNS]);
    self::$tableObjectInfo->setDataBaseName($tableConfiguration[self::DATA_BASE_NAME] ?? self::DATA_BASE_NAME_DEFAULT);
    self::$tableObjectInfo->setTableIdentifier($tableConfiguration[self::TABLE_IDENTIFIER]);
    self::$tableObjectInfo->setTableColumnsDate($tableConfiguration[self::TABLE_COLUMNS_DATE]);

    $this->initObjects();
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
    $result = $useREQUEST ? $this->removeIgnores($_REQUEST) : $result = self::$dataObject->getData(self::$tableObjectInfo->getTableColumns());
    return array_merge(self::$repositoryDataDB->getData(), $result);
  }

  /**
   * Injeta no objeto atual os valores vindos da view.
   *
   * @param array $data = null : Deve receber um array de chave e valor: array("FIELD" => "value").
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
        $isNoIgnoreLoop = in_array($key, $this->ignoreFields);

        if ($isNoIgnoreLoop && method_exists(self::$object, $method) && $value !== null) {
          self::$object->$method($value);
          $this->dataToTableObject[strtoupper($key)] = $value;
        }
      }
    } catch (\Throwable $error) {
      $result = false;
      var_dump("Erro ao tentar settar os dados vindos da view:: Error: " . $error->getMessage());
    }

    if ($result) {
      self::$repositoryDataDB->setData($this->dataToTableObject);
    }

    return $result;
  }

  /**
   * Adiciona campos vindos da view que serão ignorados ao usar o os métodos  setAllData e setDataFromArray.
   * Por padrão ele sempre irá ignorar o compo ACAO
   *
   * @param array $ignore = null : deve conter um array com os campos vindos da view que serão ignorados.
   * @param bool $isAddInArray = false : informa se os valores passados deve ser adicionados ou escritos como novos.
   *
   * @return void
   */
  public function ignoreViewField(array $ignore, bool $isAddInArray = false): void
  {
    if (!empty($ignore) && $isAddInArray === false) {
      $this->ignoreFields = array_merge($ignore, array(self::ACAO));
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
    return self::$querySql->select($tableColumns);
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

    $result = self::$createDataDB->create($tableColumns);
    $this->clean();

    return $result;
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
    $data = self::$findData->find($tableIdentifier, $tableColumns);
    $this->clean();

    return $data;
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
    $data = self::$findAllData->findAll($tableColumns);
    $this->clean();

    return $data;
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
   * @return self
   */
  public function audit(int $cd_evento, string $ds_complemento): self
  {
    $dataAudit = array("CD_EVENTO" => $cd_evento, "DS_COMPLEMENTO" => $ds_complemento);
    self::$audit->setData($dataAudit);

    return $this->isMakeAudit();
  }

  /**
   * @return self
   */
  public function isMakeAudit(bool $isMakeAudit = true): self
  {
    self::$audit->notify($isMakeAudit);
    return $this;
  }

  /**
   * @param string $typeQuery Deve receber o comando desejado.
   *
   * #### Comando INSERT: INSERIR, CRIAR, INSERT ou CREATE.
   * #### Comando DELETE: APAGAR, DELETAR, REMOVER, DELET ou REMOVE.
   * #### Comando UPDATE: ATUALIZAR, EDITAR, EDIT ou UPDATE.
   * #### Comandos SELECT ou FINDALL: BUSCAR, PROCURAR, PESQUISAR, SELECIONAR, SELECT, SEARCH ou FINDALL.
   * #### Comando FIND: ENCONTRAR ou FIND.
   * #### Comandos JOIN: UNIR, LIGAR, JUNTAR, JUNTE-SE ou JOIN.
   * #### Comando WHERE: ONDE, CODIÇÃO, CODIÇÕES, WHERE, CONDITION ou CONDITIONS.
   * #### Comando GROUP BY: GRUPO, GRUPO POR, GROUP ou GROUP BY.
   * #### Comando ORDER BY: ORDENAR, ORDENAR POR, ORDER ou ORDER BY.
   *
   * @return string
   */
  public function queryString(string $typeQuery = null): string
  {
    return self::$querySql->queryString($typeQuery);
  }

  /**
   * Limpa os dados injetados para uso no DB.
   *
   * @return void
   */
  public function clean(): void
  {
    $this->dataToTableObject = array();
    self::$querySql->clean();
    self::$repositoryDataDB->clean();
  }
}
