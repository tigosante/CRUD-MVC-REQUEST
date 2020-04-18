<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "_classes/ConexaoM.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "_classes_abstratas/AbstractModel.class.php");

class ModelDefault extends AbstractModelCore
{
    public function __construct()
    {
        parent::__construct(new ConexaoM);
    }

    public function get($objeto, $tipo = "")
    {
        if (strtoupper($tipo) === "COMBO") {
            return $this->retornar_dados_json($objeto);
        } else if (strtoupper($tipo) === "CLOB") {
            return $this->retornar_dados_clob($objeto);
        } else {
            return $this->retornar_dados($objeto);
        }
    }

    public function post($objeto)
    {
        return $this->executar_comando($objeto);
    }

    public function put($objeto)
    {
        return $this->executar_comando($objeto);
    }

    public function delete($objeto)
    {
        return "";
    }
}
