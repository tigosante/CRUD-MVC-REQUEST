<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/abstract/AbModel.php");

class Model extends AbModel
{
    public function teste()
    {
        $comando = $this->pdo->prepare("SELECT * FROM `teste`");
        if ($comando->execute()) {
            return $comando->fetchAll()[0]["nome"];
        }

        return $comando->errorInfo();
    }
}
