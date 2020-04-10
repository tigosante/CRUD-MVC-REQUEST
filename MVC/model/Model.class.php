<?php

class Model extends AbstractModel
{
    private $connection;
    private $acaoValidate;
    private $usuarioObject;
    private $usuarioValidate;


    public function __construct(string $acao)
    {
        $request = $_REQUEST["METHOD_REQUEST"];
        $this->acaoValidate = $acao . "Validate";

        if ($request !== "PUT" && $request !== "DELETE" && !method_exists($this, $this->acaoValidate)) {
            echo "O método não existe.";
            die();
        }

        $this->connection = new Connection;

        $this->usuarioObject = UsuarioObject::ini($acao);
        $this->usuarioValidate = UsuarioObject::validate($acao);

        // Podemos fazer sem isso.
        parent::__construct($this->connection);
    }

    protected function get(): array
    {
        if ($this->usuarioValidate) {
            return $this->retornaDados($this->usuarioOb);
        }
    }

    protected function post(): string
    {
        if ($this->usuarioValidate) {
            return $this->executaComando($this->usuarioOb);
        }
    }

    protected function put(): string
    {
        return $this->executaComando($this->usuarioOb);
    }

    protected function delete(): string
    {
        return "";
    }
}
