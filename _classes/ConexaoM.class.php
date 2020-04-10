<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "_interfaces/Conexao.interface.php";

class ConexaoM implements ConexaoDB
{
    public static $instance;

    public $conexao;

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new ConexaoM();
        }
        return self::$instance;
    }

    public function __construct()
    {
        if (empty($_SERVER["HTTP_X_REQUESTED_WITH"]) && basename($_SERVER["REQUEST_URI"]) == basename(__FILE__)) {
            print("<script>location.replace(location.origin);</script>");
            throw new InvalidArgumentException();
        }

        $dados_da_conexao = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP) (HOST = " . $_SERVER["PPC_DB_HOST"] . ") (PORT = 1521)) (CONNECT_DATA = (SERVICE_NAME = " . $_SERVER["PPC_DB_SERVICE"] . ")))";
        $this->conexao = oci_connect($_SERVER["PPC_DB_USER"], $_SERVER["PPC_DB_PASSWORD"], $dados_da_conexao, "UTF8");
    }

    public function conexao_fechar()
    {
        if ($this->conexao) {
            oci_close($this->conexao);
        }
    }

    public function preparar_comando($comando)
    {
        return oci_parse($this->conexao, $comando);
    }
}
