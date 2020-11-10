<?php

namespace src\core\dataObject;

use src\interfaces\DataObject\DataObjectInterface;
use src\core\Helpers\Validation;

class DataObject implements DataObjectInterface
{
  private static object $object;

  /**
   * @return self
   */
  public static function config(object &$object): self
  {
    self::$object = $object;
    return new self;
  }

  /**
   * @return array
   */
  public function getData(array $columns): array
  {
    $dataObject = array();
    try {
      foreach ($columns as $column) {
        if (Validation::isToDate($column)) {
          $column = $this->getFixedToDate($column);
        }

        $method = "get_" . strtolower($column);

        if (method_exists(self::$object, $method)) {
          $data = self::$object->$method();

          if ($data !== NULL) {
            $dataObject[strtoupper($column)] = $data;
          }
        }
      }
    } catch (\Throwable $error) {
      var_dump("Erro ao tentar buscar os dados do objeto atual:: Error: " . $error->getMessage());
    }

    return $dataObject;
  }

  private function getFixedToDate(string $field): string
  {
    $withoutInit = substr(strtoupper(trim($field)), 9);
    $withoutEnd = substr(strtoupper(strrev($withoutInit)), 15);

    return strrev(trim($withoutEnd));
  }
}
