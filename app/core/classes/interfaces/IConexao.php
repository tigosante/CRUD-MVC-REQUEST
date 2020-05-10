<?php

interface IConexao
{
    public static function getInstance();
    public function errorConexao($error);
}
