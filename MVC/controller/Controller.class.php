<?php

class Controller extends AbstractController
{
    private $model;

    public function __construct()
    {
        $request = $_REQUEST["METHOD_REQUEST"];

        $this->model = new Model(trim($_REQUEST["acao"]));

        switch ($request) {
            case 'POST':
                echo $this->model->post();
                break;
            case 'PUT':
                echo $this->model->put();
                break;
            case 'DELETE':
                echo $this->model->delete();
                break;
            default:
                $this->corpoPesquisa($this->model->get());
                break;
        }
    }
}
