<?php

abstract class ModuloWheres
{
    protected static $executar;

    public static function wheres($acao)
    {
        $acao .= "Where";

        self::$executar = new ModuloObject;
        return self::$executar->$acao();
    }

    protected function getComboModulosWhere()
    {
        return [];
    }
}
