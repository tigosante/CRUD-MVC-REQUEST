<?php

class UsuarioModel
{
    public function buscar($dados)
    {
        return $this->$dados();
    }

    protected function usuarios()
    {
        return [
            ["nome" => "Tiago", "matricula" => 991521, "TOTALDADOS" => 15],
            ["nome" => "Tiago", "matricula" => 991521, "TOTALDADOS" => 15],
            ["nome" => "Tiago", "matricula" => 991521, "TOTALDADOS" => 15],
            ["nome" => "Tiago", "matricula" => 991521, "TOTALDADOS" => 15],
            ["nome" => "Tiago", "matricula" => 991521, "TOTALDADOS" => 15],
            ["nome" => "Tiago", "matricula" => 991521, "TOTALDADOS" => 15],
            ["nome" => "Tiago", "matricula" => 991521, "TOTALDADOS" => 15],
            ["nome" => "Tiago", "matricula" => 991521, "TOTALDADOS" => 15],
            ["nome" => "Tiago", "matricula" => 991521, "TOTALDADOS" => 15],
            ["nome" => "Tiago", "matricula" => 991521, "TOTALDADOS" => 15],
            ["nome" => "Tiago", "matricula" => 991521, "TOTALDADOS" => 15],
            ["nome" => "Tiago", "matricula" => 991521, "TOTALDADOS" => 15],
            ["nome" => "Tiago", "matricula" => 991521, "TOTALDADOS" => 15],
            ["nome" => "Tiago", "matricula" => 991521, "TOTALDADOS" => 15],
            ["nome" => "Tiago", "matricula" => 991521, "TOTALDADOS" => 15],
        ];
    }
}
