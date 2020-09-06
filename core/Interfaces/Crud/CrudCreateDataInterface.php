<?php

namespace core\interfaces\Crud;

use core\Interfaces\{
  QueryString\QueryStringInterface,
  Repository\RepositoryHandlerDataInterface
};


/**
 * @var CrudCreateDataInterface CrudHandlerDataInterface
 *
 * @method create(array $tableColumns = null): bool - Cria um novo registro de uma tabela. Pode receber um array de colunas para serem criadas.
 * @method setData(array $data): void - Injeta um array de chave e valor contendo as colunas e os dados para serem tratados em uma tabela..
 */
interface CrudCreateDataInterface
{
  public function __construct(QueryStringInterface $queryStringInterface, RepositoryHandlerDataInterface $repositoryHandlerDataInterface);

  public function create(array $tableColumns = null): bool;

  public function setData(array $data): void;
}
