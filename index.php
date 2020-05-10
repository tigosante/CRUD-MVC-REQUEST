<?php

define("DOCUMENT_ROOT", $_SERVER["DOCUMENT_ROOT"], true);
require_once(DOCUMENT_ROOT . "/app/core/config/conexao.php");

$conexao = new Conexao;

if (!isset($conexao)) {
    require_once(DOCUMENT_ROOT . "/app/home/home.php");
} else {
    require_once(DOCUMENT_ROOT . "/app/home/login/login_page.php");
}
