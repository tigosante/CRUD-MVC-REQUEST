<?php

namespace src\core\helpers;

abstract class Validation
{
  public static string $identifier = "";

  public static function isIdentifier(string $field): bool
  {
    return trim($field) === trim(self::$identifier);
  }

  public static function isSysdate(string $field): bool
  {
    return trim($field) == "SYSDATE";
  }

  public static function isFiledIdentifier(string $field): bool
  {
    return substr(strtoupper(trim($field)), 0, 3) == "SQ_";
  }

  public static function isFiledDate(string $field): bool
  {
    return substr(strtoupper(trim($field)), 0, 3) == "DT_";
  }

  public static function isToDate(string $field): bool
  {
    return substr(strtoupper(trim($field)), 0, 8) == "TO_DATE(";
  }

  public static function fixedFieldsAndOr(array $fields): array
  {
    $searcFields = array("AND ", "OR ");
    $arrayFixed = array();

    foreach ($fields as $field) {
      $peaceField = substr(strtoupper(trim($field)), 0, 4);

      if (!in_array($peaceField, $searcFields)) {
        $field = " AND " . $field;
      }

      array_push($arrayFixed, $field);
    }

    return $arrayFixed;
  }

  public static function removeIndentifierInArray(array $array): array
  {
    $indexIdentifier = array_search(trim(self::$identifier), $array);

    if ($indexIdentifier !== false) {
      unset($array[$indexIdentifier]);
    }

    return $array;
  }

  public static function identifierExists(string $text): bool
  {
    return (bool) strstr($text, ":" . self::$identifier);
  }
}
