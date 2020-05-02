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
        echo json_encode($this->$acao());
    }
}
