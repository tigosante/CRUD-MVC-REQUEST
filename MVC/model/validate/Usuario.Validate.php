<?php

abstract class UsuarioValidate
{
    public static function validate(string $acao): string
    {
        return call_user_func($acao . "Validate");
    }

    protected function getUsuarioValidate(): bool
    {
        return true;
    }

    protected function postUsuarioValidate(): bool
    {
        return true;
    }

    protected function deleteUsuarioValidate(): bool
    {
        return true;
    }
}
