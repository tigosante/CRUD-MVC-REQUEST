<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "modulo_adm/model/manter_usuario/wheres/Usuario.wheres.php");

abstract class UsuarioValidate extends UsuarioWheres
{
    protected static $executar;

    public static function validate($acao)
    {
        $acao .= "Validate";

        self::$executar = new UsuarioObject;
        return self::$executar->$acao();
    }

    protected function getUsuarioValidate()
    {
        return true;
    }

    protected function postUsuarioValidate()
    {
        return true;
    }

    protected function deleteUsuarioValidate()
    {
        return true;
    }
}
