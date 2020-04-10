<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "modulo_adm/model/manter_modulos/validation/Modulo.validation.php");

class ModuloObject extends ModuloValidation
{
    protected const CD_MODULO = 'CD_MODULO';
    protected const DS_MODULO = 'DS_MODULO';

    public static function ini($acao)
    {
        self::$executar = new ModuloObject;
        return self::$executar->$acao();
    }

    protected function getComboModulos()
    {
        return
            "SELECT "
            . self::CD_MODULO
            . "," . self::DS_MODULO
            . " FROM PPC.TB_MODULO ORDER BY "
            . self::DS_MODULO . " ASC ";
    }
}
