<?php

namespace app\Tables;

use core\TableObject\Table;

class Adm extends Table
{
  public const ID = "ID";
  public const ADM_NAME = "ADM_NAME";
  public const DT_CRIACAO = "DT_CRIACAO";

  /**
   * @var int $id
   */
  private $id;

  /**
   * @var string $adm_name
   */
  private $adm_name;

  /**
   * @var string $dt_cricao
   */
  private $dt_cricao;

  public function __construct()
  {
    $tableName = "ADM";
    $dataBaseName = "CPG.";
    $tableColumns = array(self::ID, self::DT_CRIACAO, self::ADM_NAME);
    $tableColumnsDate = array(self::DT_CRIACAO);

    $tableConfiguration = array(
      self::TABLE_NAME => $tableName,
      self::TABLE_COLUMNS => $tableColumns,
      self::DATA_BASE_NAME => $dataBaseName,
      self::TABLE_IDENTIFIER => self::ID,
      self::TABLE_COLUMNS_DATE => $tableColumnsDate
    );

    parent::__construct($tableConfiguration, $this);
  }

  public function get_id(): ?int
  {
    return $this->id;
  }

  public function set_id(int $id): void
  {
    $this->id = $id;
  }

  public function get_adm_name(): ?string
  {
    return $this->adm_name;
  }

  public function set_adm_name(string $adm_name): void
  {
    $this->adm_name = $adm_name;
  }

  public function get_dt_cricao(): ?string
  {
    return $this->dt_cricao;
  }

  public function set_dt_cricao(int $dt_cricao): void
  {
    $this->dt_cricao = $dt_cricao;
  }
}
