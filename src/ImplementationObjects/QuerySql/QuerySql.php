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
  private $querySqlStringInterface;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDBInterface
   */
  private $repositoryDataDBInterface;

  public function __construct(QuerySqlStringInterface &$querySqlStringInterface, RepositoryDataDBInterface &$repositoryDataDBInterface)
  {
    $this->querySqlStringInterface = $querySqlStringInterface;
    $this->repositoryDataDBInterface = $repositoryDataDBInterface;
  }

  public function select(array $tableColumns = null): self
  {
    $this->querySqlStringInterface->setSelect($tableColumns);
    return $this;
  }

  public function join(string $joinCondition): self
  {
    $this->querySqlStringInterface->setJoin($joinCondition);
    return $this;
  }

  public function where(array $whereCondition): self
  {
    foreach ($whereCondition as $value) {
      $this->querySqlStringInterface->setWhere($value);
    }

    return $this;
  }

  public function groupBy(array $groupByCondition): self
  {
    $this->querySqlStringInterface->setGroupBy($groupByCondition);
    return $this;
  }

  public function orderBy(array $orderByCondition): self
  {
    $this->querySqlStringInterface->setOrderBy($orderByCondition);
    return $this;
  }

  public function clean(): void
  {
    $this->querySqlStringInterface->clean();
  }

  public function fetchAll(): array
  {
    $this->repositoryDataDBInterface->setQuery($this->queryString());
    return $this->repositoryDataDBInterface->recoverData();
  }

  public function getData(): array
  {
    return $this->repositoryDataDBInterface->getData();
  }

  public function setData(array $data): void
  {
    $this->repositoryDataDBInterface->setData($data);
  }

  public function queryString(string $typeQuery = ""): string
  {
    return !empty($typeQuery) ? $this->factoryQuery($typeQuery) :
      $this->querySqlStringInterface->getSelect() .
      $this->querySqlStringInterface->getJoin() .
      $this->querySqlStringInterface->getWhere() .
      $this->querySqlStringInterface->getGroupBy() .
      $this->querySqlStringInterface->getOrderBy();
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
