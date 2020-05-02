<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/conexao/conexao.php");

$mConexao = new Conexao();
if ($mConexao->conectar()) {
    require_once($_SERVER["DOCUMENT_ROOT"] . "/screens/pg_inicial.php");
}
