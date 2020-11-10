<?php

namespace core\classes\simple_crud_helper\Repository;

use core\classes\interfaces\{
  Audit\AuditInterface,
  Repository\RepositoryDataDBInterface,
  Connections\DataBaseConnectionInterface
};

class RepositoryDataDB implements RepositoryDataDBInterface
{
  /**
   * @var \PDO $connection
   */
  private static $connection;

  /**
   * @var string $query
   */
  private $query = "";

  /**
   * @var array $data
   */
  private $data = array();

  /**
   * @var array $dataDB
   */
  private $dataDB = null;

  /**
   * @var AuditInterface $audit
   */
  private static $audit;

  public static function config(DataBaseConnectionInterface &$dataBaseConnection, AuditInterface &$audit): self
  {
    if ($dataBaseConnection->createConnection()) {
      self::$connection = $dataBaseConnection->getConnection();
    }

    self::$audit = $audit;
    return new self;
  }

  private function verifyData(): void
  {
    $dataArray = $this->getData();

    if (!(empty($dataArray))) {
      foreach ($dataArray as $key => $value) {
        $this->dataDB[":{$key}"] = $value;
      }
    }
  }

  public function recoverData(): array
  {
    $this->verifyData();
    $statement = self::$connection->prepare($this->getQuery());
    $statement->execute($this->dataDB);

    return $statement->fetchAll();
  }

  public function handleData(): bool
  {
    $result = true;

    try {
      if (self::$audit->isMakeAudit()) {
        $result = self::$audit->createAuditInDB(self::$connection);
      }

      if ($result) {
        $this->verifyData();
        $result = self::$connection->prepare($this->getQuery())->execute($this->dataDB);
      }

      if (!$result) {
        self::$audit->isMakeAudit() ? self::$connection->rollBack() : null;
        return $result;
      }

      if (self::$audit->isMakeAudit() && $result) {
        $result = self::$connection->commit();
      }
    } catch (\PDOException $error) {
      self::$connection->rollBack();
      var_dump($error->getMessage());
      $result = false;
    }

    return $result;
  }

  public function getQuery(): string
  {
    return $this->query;
  }

  public function setQuery(string $query): void
  {
    $this->query = $query;
  }

  public function getData(): array
  {
    return $this->data;
  }

  public function setData(array $data): void
  {
    if (!(empty($data))) {
      foreach ($data as $key => $value) {
        $this->data[$key] = $value;
      }
    }
  }

  public function clean(): void
  {
    $this->data = array();
    $this->query = "";
    $this->dataDB = null;
  }
}
