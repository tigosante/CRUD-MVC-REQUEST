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

    public function post($objeto, $commit = true)
    {
        return $this->tipo_comando($objeto, $commit);
    }

    public function put($objeto, $commit = true)
    {
        return $this->tipo_comando($objeto, $commit);
    }

    public function delete($objeto, $commit = true)
    {
        return $this->tipo_comando($objeto, $commit);
    }

    private function tipo_comando($objeto, $commit)
    {
        if ($commit) {
            return $this->executar_comando($objeto, $commit);
        } else {
            return $this->executar_comando_sem_commit($objeto, $commit);
        }
    }
}
