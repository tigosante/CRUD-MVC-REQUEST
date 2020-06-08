<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace modulo_tre\pesquisar_dados\View;

/**
 * namespace: Pacote/path/caminho de uma determinada classe..
 * Usado para importar uma determinada classes.
 */

use core\classes\abstracts\view;

/**
 * Objeto que trata as informações vindas do DB para apresenta-las ao usuário.
 */
class TreinamentoV extends View
{
    /**
     * Cria uma tabela com os dados dos usuários informados.
     */
    public function montar_tabela(array $dados): string
    {
        // Essa implementação é feita de maneira diferente atualmente no BRB.
        // Não use como padrão de projeto, use apenas para treino.

        return $this->montar_cabecalho(["Nome", "E-mail", "Editar", "Apagar"]) . $this->montar_corpo($dados);
    }
}