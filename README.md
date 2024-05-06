``` php
<?php

use exemple\Tables\Adm;

$tableAdm = new Adm;
$data = new DateTime;

$tableAdm->set_adm_name("Tiago");
$tableAdm->set_dt_cricao($data->format("Y-m-d"));

// Podemos usar o método setData que recebe um array de chave e valor.
$tableAdm->setData(array(
  $tableAdm::ADM_NAME => "Tiago",
  $tableAdm::DT_CRIACAO => $date->format("Y-m-d")
));

// Criação de novo registro de usuário.
$tableAdm->create();

//  ---------------------------------------------------------------------------------------

// Podemos usar por encapsulamento.
$tableAdm->set_id(1);
$tableAdm->set_adm_name("Pedro");
$tableAdm->set_dt_cricao($data->format("Y-m-d"));

$tableAdm->where($tableAdm::ID . " = :" . $tableAdm::ID)->update();

//  ---------------------------------------------------------------------------------------

$tableAdm->setData(array(
  $tableAdm::ADM_NAME => "Tiago",
  $tableAdm::DT_CRIACAO => $date->format("Y-m-d")
));

// Criação de novo registro de usuário.
$tableAdm->create();

//  ---------------------------------------------------------------------------------------

$tableAdm->set_id(2);

// Remoção de registro de usuário.
$tableAdm->where($tableAdm::ID . " = :" . $tableAdm::ID)->delete($tableAdm->get_id());

//  ---------------------------------------------------------------------------------------
// Busca de registro no banco de dados.

$tableAdm->setData(array($tableAdm::ID => 1, $tableAdm::DT_CRIACAO => "07/09/2020"));

//  Busca de vários registros com where.
$tableAdm->where($tableAdm::DT_CRIACAO . " > :" . $tableAdm::DT_CRIACAO)->findAll();

//  Busca de todos os registros pegando apenas a coluna ADM_NAME.
$tableAdm->findAll(array($tableAdm::ADM_NAME));

//  Busca de um único registro no banco de dados.
$tableAdm->set_id(1);
$tableAdm->find($tableAdm->get_id());

//  ---------------------------------------------------------------------------------------

//  Busca vários registros no banco de dados usando paginação.
$tableAdm->pagination(10, 15, 60)->findAll();
$tableAdm->pagination()->init(10)->amount(15)->end(60)->findAll();
```
