<?php

class Paginacao
{
    private $dados;
    private $corpo;
    private $tabela;
    private $cabecalho;
    private $total_dados;

    public function __construct(array $dados)
    {
        $this->dados = $dados;
        $this->tabela = "<table class='table table-striped table-bordered table-hover'>";
        $this->total_dados = $dados[0]["TOTALDADOS"];
    }

    public function montar_cabecalho(array $texto_cabecalho)
    {
        $this->cabecalho = "<thead><tr>";

        foreach ($texto_cabecalho as $texto) {
            $this->cabecalho .= "<th>$texto</th>";
        }

        $this->cabecalho .= "</tr></thead>";
    }

    private function montar_corpo()
    {
        $this->corpo = "<tbody>";

        foreach ($this->dados as $valor) {
            $this->corpo .= "<tr>";
            foreach ($valor as $chave) {
                if ($chave !== "TOTALDADOS") {
                    $this->corpo .= "<th>" . $valor[$chave] . "</th>";
                }
            }
            $this->corpo .= "</tr>";
        }

        return $this->corpo . "</tbody>";
    }

    public function montar_tabela()
    {
        var_dump("ad");
        return $this->tabela .= $this->cabecalho . $this->montar_corpo() . "</table>";
    }
}
