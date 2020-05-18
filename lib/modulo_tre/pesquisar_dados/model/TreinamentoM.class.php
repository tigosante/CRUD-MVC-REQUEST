<?php

namespace modulo_tre\pesquisar_dados\model;

use core\classes\abstracts\ModelDAO;
use modulo_tre\_objetos\TreinamentoO;

class TreinamentoM extends ModelDAO
{
    public function get_dados(TreinamentoO $treinamento): array
    {
        $binds = [];
        $this->sql = $treinamento->get_query_select();

        if ($treinamento->get_name()) {
            $this->sql .= " AND UPPER(NAME) LIKE UPPER('%':NAME'%') ";
            array_push($binds, [":NAME" => $treinamento->get_name()]);
        }

        if ($treinamento->get_email()) {
            $this->sql .= " AND UPPER(EMAIL) LIKE UPPER('%':EMAIL'%') ";
            array_push($binds, [":EMAIL" => $treinamento->get_email()]);
        }

        $dados = $this->pdo->prepare($this->sql);
        $dados->execute($binds);

        return $dados->fetchAll(\PDO::FETCH_OBJ);
    }

    public function update_dado(TreinamentoO $treinamento): bool
    {
        return $treinamento->update();
    }

    public function set_novo_dado(TreinamentoO $treinamento): bool
    {
        return $treinamento->create();
    }

    public function delete_dado(TreinamentoO $treinamento): bool
    {
        return $treinamento->delete();
    }
}