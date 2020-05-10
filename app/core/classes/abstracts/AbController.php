<?php

abstract class AbController
{
    public static function init()
    {
        $classe = get_called_class();
        return new $classe();
    }
    public function __construct()
    {
        $acao = trim($_REQUEST["acao"]);
        $resultado = $this->$acao();

        if ($resultado === true || $resultado === false) {
            echo json_encode(["resultado" => $resultado]);
        } else {
            echo json_encode($resultado);
        }
    }
}
