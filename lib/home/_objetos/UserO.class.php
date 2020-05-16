<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace home\_objetos;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/core/autoloads/autoload_default.php";



/**
 * namespace: Pacote/path de uma determinada classe.
 * Usado para importar uma determinada classes.
 */

use core\classes\abstracts\ObjetoDAO;

/**
 * Objeto que representa a tabela TB_USER.
 */
class UserO extends ObjetoDAO
{
    private $id = -1;
    private $no_user = "";
    private $ds_email = "";
    private $senha_user = "";
    private $conf_senha_user = "";

    public const NO_USER = "NO_USER";
    public const DS_EMAIL = "DS_EMAIL";
    public const SENHA_USER = "SENHA_USER";

    public function __construct($no_user = "", $ds_email = "", $senha_user = "")
    {
        $this->no_user = $no_user;
        $this->ds_email = $ds_email;
        $this->senha_user = $senha_user;
    }


    /**
     * Retorna o valor da variavel id.
     */
    public function get_id(): int
    {
        return $this->id;
    }

    /**
     * Seta um valor na variavel id.
     */
    public function set_id(int $id): void
    {
        $this->id = intval($id);
    }

    /**
     * Retorna o valor da variavel no_user.
     */
    public function get_no_user(): String
    {
        return $this->no_user;
    }

    /**
     * Seta um valor na variavel no_user.
     */
    public function set_no_user(String $no_user): void
    {
        $this->no_user = $no_user;
    }

    /**
     * Retorna o valor da variavel ds_email.
     */
    public function get_ds_email(): String
    {
        return $this->ds_email;
    }

    /**
     * Seta um valor na variavel ds_email.
     */
    public function set_ds_email(String $ds_email): void
    {
        $this->ds_email = $ds_email;
    }

    /**
     * Retorna o valor da variavel senha_user.
     */
    public function get_senha_user(): String
    {
        return $this->senha_user;
    }

    /**
     * Seta um valor na variavel senha_user.
     */
    public function set_senha_user(String $senha_user): void
    {
        $this->senha_user = $senha_user;
    }

    /**
     * Seta um valor na this. variavel
     */
    public function set_conf_senha_user(String $conf_senha_user): void
    {
        if ($this->senha_user === $conf_senha_user) {
            $this->senha_user = $conf_senha_user;
        }
    }
}