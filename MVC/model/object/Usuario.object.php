<?php

class UsuarioObject extends UsuarioValidate
{
    protected const NO_USUARIO = 'NO_USUARIO';
    protected const NR_MATRICULA = 'NR_MATRICULA';

    public static function ini(string $acao): string
    {
        return call_user_func($acao);
    }

    protected function getUsuario(): string
    {
        return
            "SELECT "
            . self::NO_USUARIO .
            "," . self::NR_MATRICULA
            . " FROM PPC.TB_USUARIO";
    }
    protected function postUsuario(): string
    {
        return
            "UPDATE PPC.TB_USUARIO SET"
            . self::NO_USUARIO . " = :" . self::NO_USUARIO .
            ","  . self::NR_MATRICULA . " = :" . self::NR_MATRICULA;
    }
    protected function putUsuario(): string
    {
        return
            "INSERT INTO PPC.TB_USUARIO("
            . self::NO_USUARIO .
            "," . self::NR_MATRICULA
            . ")VALUES("
            . ":" . self::NO_USUARIO .
            "," . ":" . self::NR_MATRICULA
            . ")";
    }
}
