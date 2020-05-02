<?php

interface IConexao
{
    public function conectar();
    public function errorConexao($error);
}
