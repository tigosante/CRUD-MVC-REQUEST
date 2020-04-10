<?php
interface ConexaoDB
{
    public static function getInstance();
    public function conexao_fechar();
    public function preparar_comando($comando);
}
