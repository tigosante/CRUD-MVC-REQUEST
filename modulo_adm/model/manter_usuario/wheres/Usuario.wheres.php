<?php

abstract class UsuarioWheres
{
    protected static $executar;

    public static function wheres($acao)
    {
        $acao .= "Where";

        self::$executar = new UsuarioObject;
        return self::$executar->$acao();
    }

    protected function getUsuarioWhere()
    {
        return [" AND NR_MATRICULA = :NR_MATRICULA "];
    }
}
