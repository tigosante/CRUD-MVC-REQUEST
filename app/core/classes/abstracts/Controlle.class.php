<?php

/**
 * nome do pacote/path ao qual esta classe pertence.
 */

namespace core\classes\abstracts;

require_once $_SERVER["DOCUMENT_ROOT"] . "/app/config/autoloads/autoload_default.php";
abstract class Controller
{
    public static function init(): object
    {
        $classe = get_called_class();
        return new $classe();
    }

    public function __construct()
    {
        $acao = trim($_REQUEST["acao"]);
        $resultado = $this->$acao();

        if ($resultado === true || $resultado === false) {
            echo json_encode(["resultado" => $resultado]);
        } else {
            echo json_encode($resultado);
        }
    }
}
