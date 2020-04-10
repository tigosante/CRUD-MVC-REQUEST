<?php

require_once($_SERVER["DOCUMENT_ROOT"] . "_classes_abstratas/AbstractModel.class.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "modulo_adm/model/manter_usuario/object/Usuario.object.php");

class UsuarioModel extends AbstractModelCore
{
    private $classe;
    private $conexao;
    private $acaoValidate;

    private $comando;
    private $validacao;
    private $condicoes;


    public function __construct(string $acao)
    {
        $request = $_SERVER["REQUEST_METHOD"];

        $this->acaoValidate = $acao . "Validate";
        $this->classe = new UsuarioObject;

        if ($request !== "PUT" && $request !== "DELETE" && !method_exists($this->classe, $this->acaoValidate)) {
            throw new InvalidArgumentException("O método não existe.");
        }

        $this->comando = $this->classe::ini($acao);
        $this->validacao = $this->classe::validate($acao);
        $this->condicoes = $this->classe::wheres($acao);

        $this->conexao = new ConexaoM;
        parent::__construct($this->conexao);
    }

    public function get()
    {
        if ($this->validacao) {
            return $this->retornaDados($this->comando, $this->condicoes);
        }
    }

    public function post()
    {
        if ($this->validacao) {
            return $this->executar_comando($this->comando . $this->condicoes);
        }
    }

    public function put()
    {
        return $this->executar_comando($this->comando . $this->condicoes);
    }

    public function delete()
    {
        return "";
    }
}
