<?php
class Connection implements ConnectionDB
{
    protected $connection;

    public function getInstance()
    {
        // Método.
    }

    public function fechaConexao(): void
    {
        oci_close($this->connection);
    }

    public function preparaComando(string $comando)
    {
        return oci_parse($this->connection, $comando);
    }
}
