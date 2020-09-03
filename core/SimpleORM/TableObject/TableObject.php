<?php

namespace core\TableObject\TableObject;

use core\interfaces\TableObject\TableObjectInterface;

class TableObject implements TableObjectInterface
{
  /**
   * @var object $object
   */
  private $object;

  public function __construct(object $object)
  {
    $this->object = $object;
  }
  public function setAllData(): bool
  {
    $result = true;

    try {
      foreach ($_REQUEST as $key => $value) {
        $method = "set_" . $key;

        if ($key !== "acao" && method_exists($this->object, $method)) {
          $this->object->$method($value);
        }
      }
    } catch (\Throwable $error) {
      $result = false;
      var_dump("Erro ao tentar settar os dados vindos da view:: Error: " . $error->getMessage());
    }

    return $result;
  }
  public function setAllDataFromArray(array $dataArray): bool
  {
    $result = true;

    try {
      foreach ($dataArray as $key => $value) {
        $method = "set_" . strtolower($key);

        if (method_exists($this->object, $method)) {
          $this->object->$method($value);
        }
      }
    } catch (\Throwable $error) {
      $result = false;
      var_dump("Erro ao tentar settar os dados vindos de um array:: Error: " . $error->getMessage());
    }

    return $result;
  }
}
