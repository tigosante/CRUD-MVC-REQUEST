<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "_classes/ModelDefault.class.php");
/**
 * Parâmentros.
 * @param cParametro $cParametro Variável de parâmetros padrão da classe.

 * Funções.
 * @param function enviar_parametro($destino)
 * @param function verificar_erro_retorno($retorno)
 * @param function retornar_erro($codigo, $mensagem, $erro)
 *
 * @author     Pedro Godoy, Tiago Silva.
 * @copyright  PPC - Plataforma de Planejamento e Controle.
 * @version    1.0.
 */
abstract class AbstractControllerCore
{
    protected $model;
    private $retornoPesquisa = "";

    public function __construct()
    {
        $this->model = new ModelDefault;
        $this->acao();
    }

    public static function init()
    {
        $classe = get_called_class();
        return new $classe();
    }

    private function acao()
    {
        $acao = trim($_REQUEST["acao"]);
        return $this->$acao();
    }


    protected function montar_tabela($dados)
    {
        foreach ($dados as $value) {
            $this->retornoPesquisa .= "<strong>Matrícula: " . $value["NR_MATRICULA"] . "</strong>" . "</br>" . "<strong>Nome: " . $value["NO_USUARIO"] . "</strong>" . "</br></br>";
        }

        return $this->retornoPesquisa;
    }

    /**
     * Envia os parâmetros da view para o Model.
     * Remove a $acao vinda da view.
     * Verifica quais campos da view contém conteúdo e envia para: $destino->mParametro_bind['campo da view'].
     *
     * @param   parametro  $destino Instância de uma classe Model.
     *
     * @author Tiago Silva.
     * @copyright  PPC - Plataforma de Planejamento e Controle.
     * @version    1.0.
     */
    protected function enviar_parametro()
    {
        foreach (array_keys($_REQUEST) as $campo_view) {
            if (!(empty(trim($_REQUEST[$campo_view]))) || $_REQUEST[$campo_view] === "0" && $campo_view !== $_REQUEST["acao"]) {
                $this->model->mParametro_bind[$campo_view] = trim($_REQUEST[$campo_view]);
            }
        }
    }
}
