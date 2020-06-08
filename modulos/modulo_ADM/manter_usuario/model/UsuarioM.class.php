<?php

namespace modulo_adm\modulo\model;

use core\classes\abstracts\ModelDAO;
use home\_objetos\UserO;

class UsuarioM extends ModelDAO
{
    public function criar_usuario(UserO $usuario)
    {
        $condition_nr_matricula = "AND NR_MATRICULA = 991521";
        $conditions = [$condition_nr_matricula, " OR NO_USUARIO LIKE %tiago%"];

        $usuario->create();
        $usuario->insert()->execute();

        $usuario->select()
            ->join("LEFT", "TB_MODULO AS MD", "ON (MD.CD_MODULO = USU.CD_MODULO)")
            ->join("INNER", "VW_DEPENDENCIA AS VW", "ON (VW.CD_EMPRESA_DEPENDENCIA = USU.CD_EMPRESA_DEPENDENCIA)")
            ->where($condition_nr_matricula)->fetch();

        $usuario->select()->where_array($conditions)->fetch_all();

        $usuario->update()->execute();
        $usuario->update(991521, "=")->where("AND NO_USUARIO LIKE %TIAGO%")->execute();

        $usuario->delete()->where($condition_nr_matricula)->execute();
        $usuario->delete()->where_array($conditions)->execute();
    }
}