<?php

namespace core\classes\simple_crud_helper\QuerySql;

use core\classes\interfaces\{
  QuerySql\QuerySqlInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

class QuerySql implements QuerySqlInterface
{
  /**
   * @var QuerySqlStringInterface $querySqlString
   */
  private static $querySqlString;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDB
   */
  private static $repositoryDataDB;

  public static function config(QuerySqlStringInterface &$querySqlString, RepositoryDataDBInterface &$repositoryDataDB): self
  {
    self::$querySqlString = $querySqlString;
    self::$repositoryDataDB = $repositoryDataDB;
    return new self;
  }

  public function select(array $tableColumns = null): self
  {
    self::$querySqlString->setSelect($tableColumns);
    return $this;
  }

  public function join(string $joinCondition): self
  {
    self::$querySqlString->setJoin($joinCondition);
    return $this;
  }

  public function where(array $whereCondition): self
  {
    foreach ($whereCondition as $value) {
      self::$querySqlString->setWhere($value);
    }

    return $this;
  }

  public function groupBy(array $groupByCondition): self
  {
    self::$querySqlString->setGroupBy($groupByCondition);
    return $this;
  }

  public function orderBy(array $orderByCondition, string $type = "ASC"): self
  {
    self::$querySqlString->setOrderBy($orderByCondition, $type);
    return $this;
  }

  public function clean(): void
  {
    self::$querySqlString->clean();
  }

  public function fetchAll(): array
  {
    self::$repositoryDataDB->setQuery($this->queryString());
    return self::$repositoryDataDB->recoverData();
  }

  public function getData(): array
  {
    return self::$repositoryDataDB->getData();
  }

  public function setData(array $data): void
  {
    self::$repositoryDataDB->setData($data);
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
  public function queryString(string $typeQuery = ""): string
  {
    return !empty($typeQuery) ? $this->factoryQuery($typeQuery) :
      self::$querySqlString->getSelect() .
      self::$querySqlString->getJoin() .
      self::$querySqlString->getWhere() .
      self::$querySqlString->getGroupBy() .
      self::$querySqlString->getOrderBy();
  }

  private function factoryQuery(string $typeQuery): string
  {
    $query = "";

    switch (strtoupper(trim($typeQuery))) {
      case "INSERIR":
      case "CRIAR":
      case "INSERT":
      case "CREATE":
        $query = self::$querySqlString->getInsert();
        break;

      case "APAGAR":
      case "DELETAR":
      case "REMOVER":
      case "DELETE":
      case "REMOVE":
        $query = self::$querySqlString->getDelete() . self::$querySqlString->getWhere();
        break;

      case "ATUALIZAR":
      case "EDITAR":
      case "EDIT":
      case "UPDATE":
        $query = self::$querySqlString->getUpdate() . self::$querySqlString->getWhere();
        break;

      case "BUSCAR":
      case "PROCURAR":
      case "PESQUISAR":
      case "SELECIONAR":
      case "SELECT":
      case "SEARCH":
      case "FINDALL":
        $query = self::$querySqlString->getSelect();
        break;

      case "ENCONTRAR":
      case "FIND":
        $query = self::$querySqlString->getSelect() . self::$querySqlString->getWhere();
        break;

      case "UNIR":
      case "LIGAR":
      case "JUNTAR":
      case "JUNTE-SE":
      case "JOIN":
        $query = self::$querySqlString->getJoin();
        break;

      case "ONDE":
      case "CODIÇÃO":
      case "CODIÇÕES":
      case "WHERE":
      case "CONDITION":
      case "CONDITIONS":
        $query = self::$querySqlString->getWhere();
        break;

      case "GRUPO":
      case "GRUPO POR":
      case "GROUP":
      case "GROUP BY":
        $query = self::$querySqlString->getGroupBy();
        break;

      case "ORDENAR":
      case "ORDENAR POR":
      case "ORDER":
      case "ORDER BY":
        $query = self::$querySqlString->getOrderBy();
        break;

      default:
        $query = "Informe um comando válido de banco de dados!";
        break;
    }

    return $query;
  }
}
