<?php

namespace core\Interfaces\MVC;

/**
 * @method init(): void
 * @method action(): void
 */
interface ControllerInterface
{
  public static function init(): void;
  public function action(): void;
}
