<?php

namespace core\MVC;

use core\Interfaces\MVC\ControllerInterface;

abstract class Controller implements ControllerInterface
{
  private const ACTION = "acao";

  public static function init(): void
  {
    $nameClassCalled = get_called_class();
    (new $nameClassCalled())->action();
  }

  public function action(): void
  {
    $this->actionVerify() ? $this->actionExecution() : $this->ActionError();
  }

  private function actionVerify(): bool
  {
    return isset($_REQUEST[self::ACTION]);
  }

  private function actionExecution(): void
  {
    $actionMethod = $_REQUEST[self::ACTION];
    $this->$actionMethod();
  }

  private function ActionError(): void
  {
    $action = $_REQUEST[self::ACTION];
    var_dump("Error ao executar a '{$action}'. Por favor, verifique o nome do método ou o valor passado via JS.");
  }
}
