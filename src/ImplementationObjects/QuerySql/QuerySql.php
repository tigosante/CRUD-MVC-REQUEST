<?php

namespace src\ImplementationObjects\QuerySql;

use src\interfaces\{
  QuerySql\QuerySqlInterface,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

class QuerySql implements QuerySqlInterface
{
  /**
   * @var QuerySqlStringInterface $querySqlStringInterface
   */
  private static $querySqlStringInterface;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDBInterface
   */
  private static $repositoryDataDBInterface;

  public static function config(QuerySqlStringInterface &$querySqlStringInterface, RepositoryDataDBInterface &$repositoryDataDBInterface): self
  {
    self::$querySqlStringInterface = $querySqlStringInterface;
    self::$repositoryDataDBInterface = $repositoryDataDBInterface;

    return new self;
  }

  public function select(array $tableColumns = null): self
  {
    self::$querySqlStringInterface->setSelect($tableColumns);
    return $this;
  }

  public function join(string $joinCondition): self
  {
    self::$querySqlStringInterface->setJoin($joinCondition);
    return $this;
  }

  public function where(array $whereCondition): self
  {
    foreach ($whereCondition as $value) {
      self::$querySqlStringInterface->setWhere($value);
    }

    return $this;
  }

  public function groupBy(array $groupByCondition): self
  {
    self::$querySqlStringInterface->setGroupBy($groupByCondition);
    return $this;
  }

  public function orderBy(array $orderByCondition): self
  {
    self::$querySqlStringInterface->setOrderBy($orderByCondition);
    return $this;
  }

  public function clean(): void
  {
    self::$querySqlStringInterface->clean();
  }

  public function fetchAll(): array
  {
    self::$repositoryDataDBInterface->setQuery($this->queryString());
    return self::$repositoryDataDBInterface->recoverData();
  }

  public function getData(): array
  {
    return self::$repositoryDataDBInterface->getData();
  }

  public function setData(array $data): void
  {
    self::$repositoryDataDBInterface->setData($data);
  }

  public function queryString(string $typeQuery = ""): string
  {
    return
      self::$querySqlStringInterface->getSelect() .
      self::$querySqlStringInterface->getJoin() .
      self::$querySqlStringInterface->getWhere() .
      self::$querySqlStringInterface->getGroupBy() .
      self::$querySqlStringInterface->getOrderBy();
  }

  private function factoryQuery(string $typeQuery): string
  {
    $query = "";

    switch (strtoupper(trim($typeQuery))) {
      case "INSERIR":
      case "CRIAR":
      case "INSERT":
      case "CREATE":
        $query = $this->querySqlStringInterface->getInsert();
        break;

      case "APAGAR":
      case "DELETAR":
      case "REMOVER":
      case "DELETE":
      case "REMOVE":
        $query = $this->querySqlStringInterface->getDelete() . $this->querySqlStringInterface->getWhere();
        break;

      case "ATUALIZAR":
      case "EDITAR":
      case "EDIT":
      case "UPDATE":
        $query = $this->querySqlStringInterface->getUpdate() . $this->querySqlStringInterface->getWhere();
        break;

      case "BUSCAR":
      case "PROCURAR":
      case "PESQUISAR":
      case "SELECIONAR":
      case "SELECT":
      case "SEARCH":
      case "FINDALL":
        $query = $this->querySqlStringInterface->getSelect();
        break;

      case "ENCONTRAR":
      case "FIND":
        $query = $this->querySqlStringInterface->getSelect() . $this->querySqlStringInterface->getWhere();
        break;

      case "UNIR":
      case "LIGAR":
      case "JUNTAR":
      case "JUNTE-SE":
      case "JOIN":
        $query = $this->querySqlStringInterface->getJoin();
        break;

      case "ONDE":
      case "CODIÇÃO":
      case "CODIÇÕES":
      case "WHERE":
      case "CONDITION":
      case "CONDITIONS":
        $query = $this->querySqlStringInterface->getWhere();
        break;

      case "GRUPO":
      case "GRUPO POR":
      case "GROUP":
      case "GROUP BY":
        $query = $this->querySqlStringInterface->getGroupBy();
        break;

      case "ORDENAR":
      case "ORDENAR POR":
      case "ORDER":
      case "ORDER BY":
        $query = $this->querySqlStringInterface->getOrderBy();
        break;

      default:
        $query = "Informe um comando válido de banco de dados!";
        break;
    }

    return $query;
  }
}
