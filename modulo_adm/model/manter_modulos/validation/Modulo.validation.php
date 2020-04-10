<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "modulo_adm/model/manter_modulos/wheres/Modulo.wheres.php");

abstract class ModuloValidation extends ModuloWheres
{
    protected static $executar;

    public static function validate($acao)
    {
        $acao .= "Validate";

        self::$executar = new ModuloObject;
        return self::$executar->$acao();
    }

    protected function getComboModulosValidate()
    {
        return true;
    }
}
