<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/controller/abstract/AbController.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/model.php");

class Controller extends AbController
{
    private $model;

    public function __construct()
    {
        $this->model = new Model();
        parent::__construct();
    }

    public function buscar_dados()
    {
        return $this->model->buscar("teste");
    }
}

Controller::init();
