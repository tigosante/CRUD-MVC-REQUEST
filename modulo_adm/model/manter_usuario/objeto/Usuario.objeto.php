<?php

class UsuarioObjeto
{
    public $condicoes = [];
    public $complemento = "";


    protected const NO_USUARIO = 'NO_USUARIO';
    protected const NR_MATRICULA = 'NR_MATRICULA';

    protected function get_usuario()
    {
        $this->condicoes = [" AND " . self::NR_MATRICULA . " = :" . self::NR_MATRICULA . " "];
        $this->complemento = " ORDER BY " . self::NO_USUARIO . " ASC ";

        return
            "SELECT "
            . self::NO_USUARIO .
            "," . self::NR_MATRICULA
            . " FROM PPC.TB_USUARIO ";
    }
    protected function post_usuario()
    {
        return
            "UPDATE PPC.TB_USUARIO SET"
            . self::NO_USUARIO . " = :" . self::NO_USUARIO .
            ","  . self::NR_MATRICULA . " = :" . self::NR_MATRICULA;
    }

    protected function put_usuario()
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
