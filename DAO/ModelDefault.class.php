<?php

class ModelDefault
{
    protected function get($objeto)
    {
        return $this->conexao->retornar_dados($this->ajusta_comado($objeto));
    }

    private function ajusta_comado($objeto)
    {
        return $objeto->getComando() . $this->condicoes($objeto->getConcicoes());
    }

    private function condicoes($condicoes)
    {
        return $condicoes;
        // Usar função que já está pronta.
    }

    private function retornar_dados($dados)
    {
        return $dados;
        // Usar função que já está pronta.
    }
}
