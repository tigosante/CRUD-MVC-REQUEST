<?php

abstract class AbstractController
{
    private $retornoPesquisa = "";

    protected function corpoPesquisa(array $dados)
    {
        foreach ($dados as $value) {
            $this->retornoPesquisa .= $value;
        }

        echo $this->retornoPesquisa;
    }
}
