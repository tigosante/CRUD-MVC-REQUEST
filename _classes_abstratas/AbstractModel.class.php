<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "_interfaces/Conexao.interface.php";

/**
 * Parâmentros.
 * @param   mParametro       $mParametro       Variável de parâmetros padrão da classe.
 * @param   mParametro_bind  $mParametro_bind  Variável usada para passar parâmetros para os comandos(query) nas classes Model.
 * @param   mConexao         $mConexao         Variável de conexão com a classe ConexaoM.
 * @param   mUsuario         $mUsuario         Variável de conexão com a classe UsuarioM.
 * @param   mAuditoria       $mAuditoria       Variável de conexão com a classe AuditoriaM.

 * Funções.
 * @param function busca_string($buscador, $local_busca)
 * @param function executa_binds($retorno)
 * @param function executar_comando($retorno_banco)
 * @param function executar_comando_auditoria($retorno_banco, $comando)
 * @param function filtros_comando($filtros)
 * @param function retornar_array($retorno_banco)
 * @param function retornar_array_clob($retorno_banco)
 * @param function retornar_array_json($retorno_banco)
 *
 * @author     Pedro Godoy, Tiago Silva.
 * @copyright  PPC - Plataforma de Planejamento e Controle.
 * @version    1.0.
 */
abstract class AbstractModelCore
{
    public $mParametro;
    public $mParametro_bind;

    private $mConexao;
    private $oracleOb;

    public function __construct(ConexaoDB $conexao)
    {
        $this->mConexao = $conexao::getInstance();
    }

    public function __destruct()
    {
        $this->mConexao->conexao_fechar();
    }

    protected function retornar_dados($objeto)
    {
        $this->finalizar_comando($objeto);
        return $this->dados();
    }

    protected function retornar_dados_json($objeto)
    {
        $this->finalizar_comando($objeto);
        return $this->dados_json();
    }

    protected function retornar_dados_clob($objeto)
    {
        $this->finalizar_comando($objeto);
        return $this->dados_CLOB();
    }

    private function finalizar_comando($objeto)
    {
        $metodo = trim($_REQUEST["acao"]);
        $comando = $objeto->$metodo();

        $objeto->condicoes = $this->finalizar_condicoes($objeto->condicoes);
        $this->oracleOb = $this->mConexao->preparar_comando($comando . $objeto->condicoes . $objeto->complemento);

        if ($objeto->condicoes) {
            $this->binds();
        }
    }

    /**
     * Retorna uma string com todas as condições que receberão conteúdo da view.
     * Verifica quais conteúdos vindos da view existem no Array $filtros e concatena em uma string.
     *
     * @param   filtros   $filtros Array com condições que serão utilizadas no comando.
     * @return  String
     *
     * @author Tiago Silva.
     * @copyright  PPC - Plataforma de Planejamento e Controle
     * @version    1.0
     */
    protected function finalizar_condicoes($filtros = [])
    {
        $condicoes   = "";
        $quantidade  = count($filtros);

        foreach (array_keys($this->mParametro_bind) as $filtro) {
            for ($i = 0; $i < $quantidade; $i++) {
                if ($this->busca_string("%" . ":" . strtoupper($filtro) . "%", $filtros[$i])) {
                    $condicoes .= $filtros[$i];
                    unset($filtros[$i]);
                }
            }
        }

        return empty($condicoes) ? " " : " WHERE 1=1 " . $condicoes;
    }

    /**
     * Busca uma string dentro de outra.
     *
     * @param String  $buscador     string que será buscada.
     * @param String  $local_busca  String que será verificada.
     *
     * @author Tiago Silva.
     * @copyright  PPC - Plataforma de Planejamento e Controle
     * @version    1.0
     */
    protected function busca_string($buscador, $local_busca)
    {
        return preg_match("/" . str_replace("%", ".*?", $buscador) . "/", $local_busca) > 0;
    }

    /**
     * Executa a função OCI_BIND_BY_NAME somente nas BINDS que contém conteúdo vindos da view.
     *
     * @param retorno   $retorno  Statement do comando.
     *
     * @author Tiago Silva.
     * @copyright  PPC - Plataforma de Planejamento e Controle
     * @version    1.0
     */
    protected function binds()
    {
        foreach (array_keys($this->mParametro_bind) as $bind) {
            oci_bind_by_name($this->oracleOb, ":" . strtoupper($bind), $this->mParametro_bind[$bind]);
        }
    }

    /**
     * comentar.
     * comentar.
     * comentar.
     *
     * @param   parametro  $ comentar.
     * @author .
     * @copyright  PPC - Plataforma de Planejamento e Controle.
     * @version    1.0.
     */
    protected function executar_comando()
    {
        return oci_execute($this->oracleOb) ? "sucesso" : $this->retornar_erro();
    }

    /**
     * comentar.
     * comentar.
     * comentar.
     *
     * @param   parametro  $ comentar.
     * @author .
     * @copyright  PPC - Plataforma de Planejamento e Controle.
     * @version    1.0.
     */
    protected function executar_comando_sem_commit($retorno_banco)
    {
        return oci_execute($retorno_banco, OCI_NO_AUTO_COMMIT) ? "sucesso" : $this->retornar_erro($retorno_banco);
    }

    /**
     * comentar.
     * comentar.
     * comentar.
     *
     * @param   parametro  $ comentar.
     * @author .
     * @copyright  PPC - Plataforma de Planejamento e Controle.
     * @version    1.0.
     */
    protected function executar_comando_auditoria($retorno_banco, $comando)
    {
        return oci_execute($retorno_banco) ? $comando : $this->retornar_erro($retorno_banco);
    }

    /**
     * comentar.
     * comentar.
     * comentar.
     *
     * @param   parametro  $ comentar.
     * @author .
     * @copyright  PPC - Plataforma de Planejamento e Controle.
     * @version    1.0.
     */
    protected function dados()
    {
        if (oci_execute($this->oracleOb, OCI_NO_AUTO_COMMIT)) {
            while ($linha = oci_fetch_array($this->oracleOb, OCI_BOTH)) {
                $array[] = $linha;
            }

            return $array;
        } else {
            return $this->retornar_erro();
        }
    }

    /**
     * comentar.
     * comentar.
     * comentar.
     *
     * @param   parametro  $ comentar.
     * @author .
     * @copyright  PPC - Plataforma de Planejamento e Controle.
     * @version    1.0.
     */
    protected function dados_json()
    {
        if (oci_execute($this->oracleOb, OCI_NO_AUTO_COMMIT)) {
            while ($linha = oci_fetch_array($this->oracleOb, OCI_BOTH)) {
                $array[] = $linha;
            }

            return json_encode($array);
        } else {
            return $this->retornar_erro();
        }
    }

    /**
     * comentar.
     * comentar.
     * comentar.
     *
     * @param   parametro  $ comentar.
     * @author .
     * @copyright  PPC - Plataforma de Planejamento e Controle.
     * @version    1.0.
     */
    protected function dados_CLOB()
    {
        if (oci_execute($this->oracleOb)) {
            while ($linha = oci_fetch_array($this->oracleOb, OCI_BOTH + OCI_B_CLOB)) {
                $array[] = $linha;
            }
            return $array;
        } else {
            return $this->retornar_erro();
        }
    }

    /**
     * comentar.
     * comentar.
     * comentar.
     *
     * @param   parametro  $ comentar.
     * @author .
     * @copyright  PPC - Plataforma de Planejamento e Controle.
     * @version    1.0.
     */
    private function retornar_erro()
    {
        return json_encode("erro:" . oci_error($this->oracleOb)["message"]);
    }
}
