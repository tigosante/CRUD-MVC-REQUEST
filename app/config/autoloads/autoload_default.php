<?php

/**
 * Variáveis de configurção.
 */
define("ROOT", $_SERVER["DOCUMENT_ROOT"], true);
define("PATHS", ["/app/", "/lib/", "/tests/"], true);
define("EXTENSAO", ".class.php", true);


spl_autoload_register(function ($nameSpace) {
    foreach (PATHS as $path) {
        $dirCompleto =   ROOT . $path . get_nameSpace($nameSpace) . EXTENSAO;

        if (is_file($dirCompleto) && file_exists($dirCompleto) && (!class_exists(get_classe($nameSpace)))) {
            require_once $dirCompleto;
        }
    }
});

/**
 * Retorna o path/pacote com as \ ajustadas para /.
 */
function get_nameSpace($nameSpace)
{
    return join("/", explode("\\", $nameSpace));
}

/**
 * Retorna o nome da classe que deve ser importada.
 */
function get_classe($nameSpace)
{
    return array_reverse(explode("\\", $nameSpace))[0];
}