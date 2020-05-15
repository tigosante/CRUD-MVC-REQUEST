<?php

namespace core\classes\interfaces;

interface IConexao
{
    public static function getInstance();
    public function errorConexao($error);
}