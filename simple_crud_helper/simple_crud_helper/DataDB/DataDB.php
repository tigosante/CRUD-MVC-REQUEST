<?php

namespace core\classes\simple_crud_helper\DataDB;

use core\classes\interfaces\{
  DataDB\DataDBInterface,
  DataObject\DataObjectInterface,
  QuerySql\QuerySqlStringInterface,
  TableObject\TableObjectInfoInterface,
  Repository\RepositoryDataDBInterface
};

class DataDB implements DataDBInterface
{
  /**
   * @var DataObjectInterface $dataObject
   */
  private static $dataObject;

  /**
   * @var TableInfoInterface $tableObjectInfo
   */
  private static $tableObjectInfo;

  /**
   * @var QuerySqlStringInterface $querySqlString
   */
  private static $querySqlString;

  /**
   * @var RepositoryDataDBInterface $repositoryDataDB
   */
  private static $repositoryDataDB;

  public static function config(DataObjectInterface &$dataObject, QuerySqlStringInterface &$querySqlString, TableObjectInfoInterface &$tableObjectInfo, RepositoryDataDBInterface &$repositoryDataDB): self
  {
    self::$dataObject = $dataObject;
    self::$querySqlString = $querySqlString;
    self::$tableObjectInfo = $tableObjectInfo;
    self::$repositoryDataDB = $repositoryDataDB;

    return new self;
  }

  /**
   * Apaga um registr dentro de uma determinada tabela no DB.
   *
   * @param int $tableIdentifier = null : deve conter um número identificador de um registro no Db.
   *
   * @return bool
   */
  public function delete(int $tableIdentifier = null): bool
  {
    $tableIdentifierName = self::$tableObjectInfo->getTableIdentifier();

    if (!empty($tableIdentifierName) && !empty($tableIdentifier)) {
      self::$querySqlString->setWhere("{$tableIdentifierName} = :{$tableIdentifierName}");
      self::$repositoryDataDB->setData([$tableIdentifierName => $tableIdentifier]);
    }

    self::$querySqlString->setDelete($tableIdentifierName);
    self::$repositoryDataDB->setData(self::$dataObject->getData(self::$querySqlString->getTableColumnsData()));
    self::$repositoryDataDB->setQuery(self::$querySqlString->getDelete() . self::$querySqlString->getWhere());

    return $this->execute();
  }

  /**
   * Atualiza um registr dentro de uma determinada tabela no DB.
   *
   * @param array $tableColumns = null : deve conter um array com os nomes das colunas desejadas.
   *
   * @return bool
   */
  public function update(array $tableColumns = null): bool
  {
    self::$querySqlString->setUpdate($tableColumns);
    self::$repositoryDataDB->setQuery(self::$querySqlString->getUpdate() . self::$querySqlString->getWhere());
    self::$repositoryDataDB->setData(self::$dataObject->getData(self::$querySqlString->getTableColumnsData()));

    return $this->execute();
  }

  /**
   * Cria um condição para ser usada em uma query no DB.
   *
   * @param string $conditions : Deve conter uma condição válida.
   *
   * @return DataDBInterface
   */
  public function where(string $conditions): self
  {
    self::$querySqlString->setWhere($conditions);
    return $this;
  }

  public function getData(): array
  {
    return self::$repositoryDataDB->getData();
  }

  public function setData(array $data): void
  {
    self::$repositoryDataDB->setData($data);
  }

  private function execute(): bool
  {
    self::$querySqlString->clean();
    $result = self::$repositoryDataDB->handleData();
    self::$repositoryDataDB->clean();

    return $result;
  }
}
