<?php

define("DOCUMENT_ROOT", $_SERVER["DOCUMENT_ROOT"], true);
require_once(DOCUMENT_ROOT . "/app/core/config/conexao.php");

$conexao = new Conexao;

if (!isset($conexao)) {
    require_once(DOCUMENT_ROOT . "/app/home/screens/home.php");
} else {
    require_once(DOCUMENT_ROOT . "/app/home/screens/login_page.php");
}
