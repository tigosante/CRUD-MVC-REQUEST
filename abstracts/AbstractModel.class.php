<?php

abstract class AbstractModel
{
    private $oracleOb;
    protected $connection;

    protected function __construct(ConnectionDB $connection)
    {
        $this->connection = $connection::getInstance();
    }

    protected function retornaDados(string $comando): array
    {
        $this->oracleOb = $this->connection->preparaComando($comando);
        return $this->retornaArray($this->oracleOb);
    }

    protected function executaComando($retorno_banco): string
    {
        return oci_execute($retorno_banco) ? "sucesso" : $this->retornar_erro($retorno_banco);
    }

    private function retornaArray($oracleOb): array
    {
        return [];
    }

    private function retornar_erro($retorno_banco): string
    {
        return json_encode("erro:" . ocierror($retorno_banco)["message"]);
    }
}
