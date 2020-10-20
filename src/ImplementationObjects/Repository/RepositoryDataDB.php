<?php

namespace src\ImplementationObjects\Repository;

use src\Interfaces\{
  Repository\RepositoryDataDBInterface,
  Connections\DataBaseConnectionInterface
};
use src\Interfaces\Audit\AuditInterface;

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
  private $data = [];

  /**
   * @var array $dataDB
   */
  private $dataDB = null;

<<<<<<< HEAD
  /**
   * @return AuditInterface $auditInterface
   */
  private $auditInterface;

  public function __construct(DataBaseConnectionInterface &$dataBaseConnectionInterface, AuditInterface &$auditInterface)
=======
  public static function config(DataBaseConnectionInterface &$dataBaseConnectionInterface): self
>>>>>>> master
  {
    if ($dataBaseConnectionInterface->createConnection()) {
      self::$connection = $dataBaseConnectionInterface->getConnection();
    }

<<<<<<< HEAD
    $this->auditInterface = $auditInterface;
=======
    return new self;
>>>>>>> master
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
<<<<<<< HEAD
    $result = true;

    try {
      if ($this->auditInterface->isMakeAudit()) {
        $this->connection->beginTransaction();
        $result = $this->auditInterface->createAuditInDB($this->connection);
      }

      if ($result) {
        $this->verifyData();
        $result = $this->connection->prepare($this->getQuery())->execute($this->dataDB);
      }

      if (!$result) {
        $this->auditInterface->isMakeAudit() ? $this->connection->rollBack() : null;
        return $result;
      }

      if ($this->auditInterface->isMakeAudit() && $result) {
        $result = $this->connection->commit();
      }
    } catch (\PDOException $error) {
      $this->connection->rollBack();
      $result = false;
    }

    return $result;
=======
    $this->verifyData();
    return self::$connection->prepare($this->getQuery())->execute($this->dataDB);
>>>>>>> master
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
    $this->data = [];
    $this->query = "";
    $this->dataDB = null;
  }
}
