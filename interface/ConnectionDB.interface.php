<?php

interface ConnectionDB
{
    public function getInstance();
    public function fechaConexao();
    public function preparaComando(string $comando);
}
