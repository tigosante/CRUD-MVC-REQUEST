<?php

namespace core\SimpleORM\TableObject;

use core\SimpleORM\TableObject\TableObjectHelper;
use core\interfaces\TableObject\TableObjectInterface;

class TableObject extends TableObjectHelper implements TableObjectInterface
{
  public function setData(string $tableColumnName, $value = null): bool
  {
    $result = true;
    $method = "get_" . $tableColumnName;

    try {
      if (method_exists($this,  $method)) {
        $value = $value !== null ? $value : $_REQUEST[$tableColumnName];
        $this->$method($value);
      }
    } catch (\Throwable $error) {
      $result = false;
      var_dump("Erro ao tentar usar o método: 'get_{$tableColumnName}'. Error: " . $error->getMessage());
    }

    return $result;
  }

  public function setAllData(): bool
  {
    $result = true;

    foreach ($_REQUEST as $key => $value) {
      if ($key !== "acao") {
        $result = $this->setData($key, $value);
      }
    }

    return $result;
  }

  public function setAllDataFromArray(array $dataArray): bool
  {
    $result = true;

    foreach ($dataArray as $key => $value) {
      $result = $this->setData($key, $value);
    }

    return $result;
  }
}
