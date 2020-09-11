<?php

namespace src\Interfaces\MVC;

interface ControllerInterface
{
  public static function init(): void;
  public function action(): void;
}
