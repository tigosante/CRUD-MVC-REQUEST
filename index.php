<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/app/core/autoloads/autoload_default.php";

$conexao = new config\conexoes\Conexao;

if (isset($conexao)) {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/home/page/home.php");
}