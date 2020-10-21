<?php

namespace src\ImplementationObjects\DataObject;

use src\Interfaces\{
  DataObject\DataObjectInterface,
};

class DataObject implements DataObjectInterface
{
  /**
   * @var object $object
   */
  private static $object;

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
}
