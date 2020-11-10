<?php

namespace core\classes\simple_crud_helper\QuerySql;

use core\classes\interfaces\{
  TableObject\TableObjectInfoInterface,
  QuerySql\QuerySqlStringInterface,
  DataObject\DataObjectInterface,
};
use core\classes\simple_crud_helper\Helpers\Validation;

class QuerySqlString implements QuerySqlStringInterface
{
  private const BIND = ":";
  private const BREAK_LINE = "\n";
  private const SPACE_SEPARATOR = " ";
  private const COMMA_SEPARATOR = ", ";
  private const DUAL_SPACE_SEPARATOR = "\n    ";

  private const ASC = "ASC";
  private const SYSDATE = "SYSDATE";

  /**
   * @var string $select
   */
  private $select = "";

  /**
   * @var string $select
   */
  private $selectPagination = "";

  /**
   * @var array $joinCondition
   */
  private $joinCondition = array();

  /**
   * @var array $whereCondition
   */
  private $whereCondition = array();

  /**
   * @var array $groupByCondition
   */
  private $groupByCondition = array();

  /**
   * @var array $orderByCondition
   */
  private $orderByCondition = array();

  /**
   * @var array $tableColumnsData
   */
  private $tableColumnsData = array();

  /**
   * @var string $typeOrderBy
   */
  private $typeOrderBy = self::ASC;

  /**
   * @var string $insert
   */
  private $insert = "";

  /**
   * @var string $update
   */
  private $update = "";

  /**
   * @var string $delete
   */
  private $delete = "";

  /**
   * @var TableObjectInfoInterface $tableObjectInfo
   */
  private static $tableObjectInfo;

  /**
   * @var DataObjectInterface $dataObject
   */
  private static $dataObject;

  /**
   * @var bool $isPagination
   */
  public $isPagination = true;

  public static function config(TableObjectInfoInterface &$tableObjectInfo, DataObjectInterface &$dataObject): self
  {
    self::$dataObject = $dataObject;
    self::$tableObjectInfo = $tableObjectInfo;
    Validation::$identifier = self::$tableObjectInfo->getTableIdentifier();

    return new self;
  }

  public function getSelect(): string
  {
    return $this->select;
  }

  public function setSelect(array $tableColumns = null): void
  {
    $columns = empty($tableColumns) ? " * " : strtoupper(join(self::COMMA_SEPARATOR, $tableColumns));

    $this->select =
      "SELECT {$columns} FROM "
      . self::$tableObjectInfo->getDataBaseName()
      . self::$tableObjectInfo->getTableName()
      . self::SPACE_SEPARATOR;
  }

  /**
   * @return string
   */
  public function getSelectPagination(): string
  {
    return $this->selectPagination;
  }

  /**
   * @return void
   */
  public function setSelectPagination(string $select, int $start, int $end, int $amount)
  {
    $this->selectPagination =
      "SELECT * FROM (
          SELECT ROWNUM AS NR_LINHA_PAGINATION,TEMP.* FROM ({$select}) TEMP
      ) WHERE NR_LINHA_PAGINATION BETWEEN {$start} AND {$end} AND ROWNUM <= {$amount}";
  }

  public function getJoin(): string
  {
    return strtoupper(join(self::DUAL_SPACE_SEPARATOR, $this->joinCondition));
  }

  public function setJoin(string $joinCondition, string $typeJoin = "INNER"): void
  {
    array_push($this->joinCondition, " {$typeJoin} JOIN {$joinCondition} ");
  }

  public function getWhere(): string
  {
    $whereCommand = self::SPACE_SEPARATOR;
    $conditionsFixed = array();

    if (!empty($this->whereCondition)) {
      $this->whereCondition = array_unique($this->whereCondition);

      if (count($this->whereCondition) > 1) {
        array_push($conditionsFixed, trim($this->whereCondition[0]));
        $conditionsFixed = array_merge_recursive($conditionsFixed, Validation::fixedFieldsAndOr(array_slice($this->whereCondition, 1)));
      } else {
        $conditionsFixed = $this->whereCondition;
      }

      $whereCommand =
        " WHERE "
        . strtoupper(join(self::SPACE_SEPARATOR, $conditionsFixed))
        . self::BREAK_LINE;

      if (!empty(Validation::$identifier) && Validation::identifierExists($whereCommand)) {
        array_push($this->tableColumnsData, self::$tableObjectInfo->getTableIdentifier());
        $this->tableColumnsData = array_unique($this->tableColumnsData);
      }
    }

    return $whereCommand;
  }

  public function setWhere(string $whereCondition): void
  {
    array_push($this->whereCondition, $whereCondition);
  }

  public function getGroupBy(): string
  {
    return
      " GROUP BY "
      . strtoupper(join(self::COMMA_SEPARATOR, $this->groupByCondition))
      . self::BREAK_LINE;
  }

  public function setGroupBy(array $groupByCondition): void
  {
    $this->groupByCondition = $groupByCondition;
  }

  public function getOrderBy(): string
  {
    return
      " ORDER BY "
      . strtoupper(join(self::COMMA_SEPARATOR, $this->orderByCondition))
      . " {$this->typeOrderBy} ";
  }

  public function setOrderBy(array $orderByCondition, string $typeOrderBy = self::ASC): void
  {
    $this->typeOrderBy = $typeOrderBy;
    $this->orderByCondition = $orderByCondition;
  }

  public function getInsert(): string
  {
    return $this->insert;
  }

  public function setInsert(array $tableColumns = null): void
  {
    $columns = $this->getColumns($tableColumns);
    $columnsBinds = $this->getColumnsToBind($tableColumns);

    $this->insert =
      "INSERT INTO "
      . self::$tableObjectInfo->getDataBaseName()
      . self::$tableObjectInfo->getTableName()
      . " ({$columns}) VALUES ({$columnsBinds}) ";
  }

  public function getUpdate(): string
  {
    return $this->update;
  }

  public function setUpdate(array $tableColumns = null): void
  {
    $columns = $this->getColumnsToUpdate($tableColumns);

    $this->update =
      "UPDATE " . self::$tableObjectInfo->getDataBaseName()
      . self::$tableObjectInfo->getTableName()
      . " SET {$columns} ";
  }

  public function getDelete(): string
  {
    return $this->delete;
  }

  public function setDelete(): void
  {
    $columns = array();
    foreach (self::$dataObject->getdata(self::$tableObjectInfo->getTableColumns()) as $key => $value) {
      if ($value !== self::SYSDATE) {
        array_push($columns, $key);
      }
    }

    $this->setTableColumnsData($columns);

    $this->delete =
      "DELETE "
      . self::$tableObjectInfo->getDataBaseName()
      . self::$tableObjectInfo->getTableName()
      . self::SPACE_SEPARATOR;
  }

  public function clean(): void
  {
    $this->tableColumns = array();
    $this->joinCondition = array();
    $this->whereCondition = array();
    $this->groupByCondition = array();
    $this->orderByCondition = array();

    $this->select = "";
    $this->insert = "";
    $this->update = "";
    $this->delete = "";
    $this->typeOrderBy = self::ASC;
  }

  /**
   * @return array
   */
  public function getTableColumnsData(): array
  {
    return $this->tableColumnsData;
  }

  /**
   * @return void
   */
  public function setTableColumnsData(array $tableColumnsData): void
  {
    $this->tableColumnsData = $tableColumnsData;
  }

  private function getColumns(array $tableColumns = null): string
  {
    $columnsUpdate = array();
    $tableColumns = empty($tableColumns) ? self::$tableObjectInfo->getTableColumns() : $tableColumns;

    foreach ($tableColumns as  $column) {
      if (!Validation::isIdentifier($column)) {
        array_push($columnsUpdate, $column);
      }
    }

    return strtoupper(join(self::COMMA_SEPARATOR, $columnsUpdate));
  }

  private function getColumnsToBind(array $tableColumns = null): string
  {
    $columnsInsert = array();
    $columnsDate = self::$tableObjectInfo->getTableColumnsDate();

    if (empty($tableColumns)) {
      $tableColumns = self::$tableObjectInfo->getTableColumns();
    }

    $columnsData = self::$dataObject->getData($tableColumns);

    foreach (Validation::removeIndentifierInArray($tableColumns) as  $column) {
      if (in_array($column, $columnsDate)) {
        if ($columnsData[strtoupper($column)] === self::SYSDATE) {
          $column = self::SYSDATE;
        } else {
          $column = "TO_DATE(" . self::BIND . "{$column}, 'DD/MM/YYYY')";
        }
      }
      array_push($columnsInsert, $column);
    }

    $this->setTableColumnsData($columnsInsert);
    return strtoupper(join(self::COMMA_SEPARATOR,  $this->getFixedColumns($columnsInsert)));
  }

  private function getColumnsToUpdate(array $tableColumns = null): string
  {
    $columnsForGetData = array();
    $columnsUpdate = array();
    $columnsDate = self::$tableObjectInfo->getTableColumnsDate();

    if (empty($tableColumns)) {
      $tableColumns = self::$tableObjectInfo->getTableColumns();
    }

    $columnsData = self::$dataObject->getData($tableColumns);

    foreach (Validation::removeIndentifierInArray($tableColumns) as  $column) {
      if (in_array($column, $columnsDate)) {
        if ($columnsData[strtoupper($column)] === self::SYSDATE) {
          $column = "{$column} = " . self::SYSDATE;
        } else {
          $columnData = $column;
          $column = "{$column} = TO_DATE(" . self::BIND . "{$column}, 'DD/MM/YYYY')";
        }
      } else {
        $columnData = $column;
        $column = "{$column} = :{$column}";
      }

      array_push($columnsUpdate, $column);
      array_push($columnsForGetData, $columnData);
    }

    $this->setTableColumnsData(array_unique($columnsForGetData));
    return strtoupper(join(self::COMMA_SEPARATOR,  $columnsUpdate));
  }

  private function getFixedColumns(array $columns): array
  {
    $columnsUpdateFixed = array();

    foreach ($columns as $column) {
      if ($column === self::SYSDATE) {
        $column = self::SYSDATE;
      } else if (!Validation::isToDate($column)) {
        $column =  self::BIND . $column;
      }

      array_push($columnsUpdateFixed, $column);
    }

    return $columnsUpdateFixed;
  }
}
