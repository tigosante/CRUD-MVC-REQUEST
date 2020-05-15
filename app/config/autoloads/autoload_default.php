<?php
spl_autoload_register(function ($nameSpace) {
    definirValores();

    foreach (PATHS as  $path) {
        $dirCompleto = $path . DIR . getNameSpace($nameSpace) . EXTENSAO;

        if (is_file($dirCompleto) && file_exists($dirCompleto) && (!class_exists(getClasse($nameSpace)))) {
            require_once $dirCompleto;
        }
    }
});

function definirValores()
{
    define("DIR", $_SERVER["DOCUMENT_ROOT"], true);
    define("PATHS", ["app/", "lib/", "tests/"], true);
    define("EXTENSAO", ".class.php", true);
}

function getNameSpace($nameSpace)
{
    return join("/", explode("\\", $nameSpace));
}

function getClasse($nameSpace)
{
    return array_reverse(explode("\\", $nameSpace))[0];
}