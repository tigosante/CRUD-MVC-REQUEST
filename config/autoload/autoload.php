<?php

spl_autoload_register("load");

function load(string $classeNamespace): void
{
  $fullDir = $_SERVER["DOCUMENT_ROOT"] . "/" . getPath($classeNamespace) . ".php";

  if (is_file($fullDir) && file_exists($fullDir)) {
    require_once($fullDir);
  }
}

function getPath($classeNamespace): string
{
  return join("/", explode("\\", $classeNamespace));
}
