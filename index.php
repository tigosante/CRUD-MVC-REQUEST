<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/app/core/autoloads/autoload_default.php";

$conexao = new core\config\Conexao;

if (isset($conexao)) {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/app/home/page/home.php");
}