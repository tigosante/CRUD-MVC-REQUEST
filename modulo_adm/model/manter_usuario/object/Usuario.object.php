<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "modulo_adm/model/manter_usuario/validation/Usuario.Validate.php");

class UsuarioObject extends UsuarioValidate
{
    protected const NO_USUARIO = 'NO_USUARIO';
    protected const NR_MATRICULA = 'NR_MATRICULA';

    public static function ini($acao)
    {
        self::$executar = new UsuarioObject;
        return self::$executar->$acao();
    }

    protected function getUsuario()
    {
        return
            "SELECT "
            . self::NO_USUARIO .
            "," . self::NR_MATRICULA
            . " FROM PPC.TB_USUARIO ";
    }

    protected function postUsuario()
    {
        return
            "UPDATE PPC.TB_USUARIO SET"
            . self::NO_USUARIO . " = :" . self::NO_USUARIO .
            ","  . self::NR_MATRICULA . " = :" . self::NR_MATRICULA;
    }

    protected function putUsuario()
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
