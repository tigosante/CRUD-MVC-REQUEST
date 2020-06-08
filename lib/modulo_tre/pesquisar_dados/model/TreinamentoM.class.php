<?php

namespace modulo_tre\pesquisar_dados\model;

use core\classes\abstracts\ModelDAO;

class TreinamentoM extends ModelDAO
{
    public $parametros;

    public function get_dados(): array
    {
        $this->sql = "SELECT NAME, EMAIL FROM TRE.TB_TREINAMENTO WHERE 1=1 ";

        $binds = $this->validar_dado_nome();
        $binds = $this->validar_dado_email($binds);

        $dados = $this->pdo->prepare($this->sql);
        $dados->execute($binds);

        return $dados->fetchAll();
    }

    public function update_dado(): bool
    {
        return true;
    }

    public function set_novo_dado(): bool
    {
        return true;
    }

    public function delete_dado(): bool
    {
        return true;
    }

    private function validar_dado_nome(array $binds = []): array
    {
        if (!empty($_REQUEST["name"])) {
            $this->sql .= " AND UPPER(NAME) LIKE UPPER('%':NAME'%') ";
            array_push($binds, [":NAME" => $_REQUEST["name"]]);
        }

        return $binds;
    }

    private function validar_dado_email(array $binds = []): array
    {
        if (!empty($_REQUEST["email"])) {
            $this->sql .= " AND UPPER(EMAIL) LIKE UPPER('%':EMAIL'%') ";
            array_push($binds, [":EMAIL" => $_REQUEST["email"]]);
        }

        return $binds;
    }
}