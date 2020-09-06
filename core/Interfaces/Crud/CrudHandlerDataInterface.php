<?php

namespace core\interfaces\Crud;

use core\Interfaces\QueryString\QueryStringInterface;
use core\interfaces\Repository\RepositoryHandlerDataInterface;


/**
 * @var CrudHandlerDataInterface CrudHandlerDataInterface
 *
 * @method update(array $tableColumns = null): bool - Atualiza os dados de uma tabela. Pode receber um array de colunas para serem atualizadas.
 * @method delete(int $tableSq): bool - Apaga um registro de uma tabela usando uma $tableSq.
 * @method setData(array $data): void - Injeta um array de chave e valor contendo as colunas e os dados para serem tratados em uma tabela..
 */
interface CrudHandlerDataInterface
{
  public function __construct(QueryStringInterface $queryStringInterface, RepositoryHandlerDataInterface $repositoryHandlerDataInterface);

  public function where(string $conditions): self;

  public function update(array $tableColumns = null): bool;
  public function delete(int $tableSq): bool;

  public function setData(array $data): void;
}
