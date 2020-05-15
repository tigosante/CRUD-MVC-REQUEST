<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/app/config/autoloads/autoload_default.php";

$conexao = config\conexoes\ConexaoOracle::getInstance();

if (isset($conexao)) {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/home/page/home.php");
}