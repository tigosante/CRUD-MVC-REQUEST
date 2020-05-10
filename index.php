<?php
define($document_root, $_SERVER["DOCUMENT_ROOT"], true);

require_once($document_root . "/app/core/config/conexao.php");

if ((new Conexao())->conectar()) {
    require_once($document_root . "/screens/pg_inicial.php");
}
