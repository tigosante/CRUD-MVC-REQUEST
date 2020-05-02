<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/paginacao.php");

class UsuarioView
{
    public function montar_tabela_paginacao($dados)
    {
        $paginacao = new Paginacao($dados);
        $paginacao->montar_cabecalho(["Nome", "Matrícula"]);
        return $paginacao->montar_tabela();
    }
}
