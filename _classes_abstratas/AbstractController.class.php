<?php

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
    public $cParametro;
    private $retornoPesquisa = "";

    public static function init()
    {
        $classe = get_called_class();
        return new $classe();
    }


    protected function corpoPesquisa($dados)
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
    protected function enviar_parametro($destino, $acao = true)
    {
        if ($acao) {
            unset($_REQUEST["acao"]);
        }

        foreach (array_keys($_REQUEST) as $campo_view) {
            if (!(empty(trim($_REQUEST[$campo_view]))) || $_REQUEST[$campo_view] === "0") {
                $destino->mParametro_bind[$campo_view] = trim($_REQUEST[$campo_view]);
            }
        }
    }

    /**
     * Troca todas ou específicas chaves do $_POST e mantem a ordem original.
     * $chaves deve seguir a ordem do $_POST.\
     * Remove a $acao vinda da view.
     *
     * Mudar todas as chaves:
     * --
     * ["no_usuario", "dt_inicio", "dt_fim", "sq_chave", "cd_chave"].
     * Mudar chaves específicas:
     * --
     * ["no_usuario", "dt_inicio", null, "sq_chave", null].
     *
     * @param   array  $chaves Array de strings com novas chaves.
     * @param   bool   $acao booleano que determina se a ação será removida.
     *
     * @author Tiago Silva.
     * @copyright  PPC - Plataforma de Planejamento e Controle.
     * @version    1.0.
     */
    protected function mudar_chaves($chaves, $acao = true)
    {
        if ($acao) {
            unset($_POST["acao"]);
        }

        $novas_chaves  = [];

        for ($i = 0; $i < count($_POST); $i++) {
            if ($chaves[$i] === null) {
                $novas_chaves[array_keys($_POST)[$i]] = $_POST[array_keys($_POST)[$i]];
            } else {
                $novas_chaves[$chaves[$i]] = $_POST[array_keys($_POST)[$i]];
            }
        }

        unset($_POST);
        $_POST = $novas_chaves;
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
    protected function verificar_erro_retorno($retorno)
    {
        if (gettype($retorno) == "string") {
            return strpos($retorno, "erro") !== false;
        }
        return false;
    }

    /**
     * comentar.
     * comentar.
     * comentar.
     *
     * @param   parametro  $ comentar.
     * @author Pedro Godoy.
     * @copyright  PPC - Plataforma de Planejamento e Controle.
     * @version    1.0.
     */
    protected function retornar_erro($codigo, $mensagem, $erro)
    {
        header('HTTP/1.1 ' . $codigo . ' Internal Server Booboo');
        header('Content-Type: application/json; charset=UTF-8');
        return json_encode(array('mensagem' => $mensagem, 'erro' => $erro));
    }

    /**
     * comentar.
     * comentar.
     * comentar.
     *
     * @param   parametro  $ comentar.
     * @author Pedro Godoy.
     * @copyright  PPC - Plataforma de Planejamento e Controle.
     * @version    1.0.
     */
    protected function retornar_sem_resultados()
    {
        return "
            <div class='content'>
                <div class='row'>
                    <div class='col-md-12 text-center'>
                        <h4>Nenhum Resultado Encontrado!</h4>
                    </div>
                </div>
            </div>";
    }

    /**
     * Adiciona cores.
     * Contém duas cores default - #FFF & #E6E8FA.
     *
     * @param  int     $contador Inteiro com a posição do elemento.
     * @param  string  $cor_clara string com a cor clara.
     * @param  string  $cor_escura string com a cor escura.
     *
     * @author Tiago Silva.
     * @copyright  PPC - Plataforma de Planejamento e Controle.
     * @version    1.0.
     */
    protected function background($contador, $cor_clara = "#FFF", $cor_escura = "#E6E8FA")
    {
        return $contador % 2 == 0 ? $cor_clara : $cor_escura;
    }
}
