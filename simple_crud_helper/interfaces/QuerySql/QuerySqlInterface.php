<?php

namespace core\classes\interfaces\QuerySql;

use core\classes\interfaces\{
  Helpers\SetDataHelper,
  QuerySql\QuerySqlStringInterface,
  Repository\RepositoryDataDBInterface
};

interface QuerySqlInterface extends SetDataHelper
{
  /**
   * @return self
   */
  public static function config(QuerySqlStringInterface &$querySqlString, RepositoryDataDBInterface &$repositoryDataDB);

  /**
   * @return self
   */
  public function select(array $tableColumns = null);

  /**
   * @return self
   */
  public function join(string $joinCondition);

  /**
   * @return self
   */
  public function where(array $whereCondition);

  /**
   * @return self
   */
  public function groupBy(array $groupByCondition);

  /**
   * @return self
   */
  public function orderBy(array $orderByCondition, string $type = "ASC");


  /**
   * @return void
   */
  public function clean();

  /**
   * @return array
   */
  public function fetchAll();

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
  public function queryString(string $typeQuery = "");
}
