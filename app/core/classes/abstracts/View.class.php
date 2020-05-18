<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace core\classes\abstracts;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/config/autoloads/autoload_default.php";
/**
 * Abstração de métodos para uso em classes view.
 */
abstract class View
{
    protected function montar_cabecalho(array $headers): string
    {
        $titles = "<thead><tr>";
        foreach ($headers as $title) {
            $title .= "<th scope='col'>{$title}</th>";
        }
        $titles .= "</tr>";

        return "<table class='table'>" . $titles . "</thead>";
    }

    protected function montar_corpo(array $dados): string
    {
        $corpo = "<tbody>";
        foreach ($dados as  $dado) {
            $corpo .=  "<tr>";
            foreach ($dado as $texto) {
                $corpo .= "<th>{$texto}</th>";
            }
            $corpo .=  "</tr>";
        }

        return $corpo . "</tbody></table>";
    }
}