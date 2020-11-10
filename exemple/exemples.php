<?php

use exemple\Tables\Adm;

$tableAdm = new Adm;
$data = new DateTime;
var_dump("<pre>");

// --------------------------------------------------------------------------------
// -------------------Usando dados do $_REQUEST vindos da views.-------------------
// --------------------------------------------------------------------------------

// ---------------------------------------
// 1 - Criação de registro no banco. // //
// ---------------------------------------

$tableAdm->create();
// Dessa forma todos os dados do $_REQUEST referentes à essa tabela
// serão inseridos no banco de dado.

$columnsCreate = array($tableAdm::ADM_NAME, $tableAdm::DT_CRIACAO);
$tableAdm->create($columnsCreate);
// Dessa forma apenas os dados do $_REQUEST referentes às colunas informadas
// serão inseridos no banco de dado.

// Nos dois casos acima, colunas que não tiverem valor serão inseridas NULL (caso o banco permita).


// ---------------------------------------
// 2.1 - Busca de registro no banco. // //
// -------------Método Find---------------

$_REQUEST[$tableAdm::ID] = 1;

$tableAdm->find($_REQUEST[$tableAdm::ID]);
// Dessa forma os dados do registro com ID = 1 serão retornado em formato de array nomeado (CHAVE e VALOR).
// EXEMPLO: ["ID" => 1, "ADM_NOME" => "Tiago", "DT_CRIACAO" => "10/11/2020"]

$columnsCreate = array($tableAdm::ADM_NAME, $tableAdm::DT_CRIACAO);
$tableAdm->find($_REQUEST[$tableAdm::ID], $columnsCreate);
// Dessa forma os dados do registro com ID = 1 refentes às colunas informadas
// serão retornado em formato de array nomeado (CHAVE e VALOR).
// EXEMPLO: ["ADM_NOME" => "Tiago", "DT_CRIACAO" => "10/11/2020"]


// ---------------------------------------
// 2.1 - Busca de registro no banco. // //
// -------------Método FindAll------------

$tableAdm->findAll();
// Dessa forma todos os dados serão retornado em formato de matriz (array de array).
// EXEMPLO:
// [
// ["ID" => 1, "ADM_NOME" => "Tiago", "DT_CRIACAO" => "10/11/2020"],
// ["ID" => 2, "ADM_NOME" => "Pedro", "DT_CRIACAO" => "10/11/2020"],
// ["ID" => 3, "ADM_NOME" => "Henrique", "DT_CRIACAO" => "10/11/2020"],
// ["ID" => 4, "ADM_NOME" => "Luiz", "DT_CRIACAO" => "10/11/2020"],
// ]

$columnsCreate = array($tableAdm::ADM_NAME, $tableAdm::DT_CRIACAO);
$tableAdm->findAll($columnsCreate);
// Dessa forma todos os dados refentes às colunas informadas serão retornado em formato
// de array nomeado (CHAVE e VALOR).
// EXEMPLO:
// [
// ["ADM_NOME" => "Tiago", "DT_CRIACAO" => "10/11/2020"],
// ["ADM_NOME" => "Pedro", "DT_CRIACAO" => "10/11/2020"],
// ["ADM_NOME" => "Henrique", "DT_CRIACAO" => "10/11/2020"],
// ["ADM_NOME" => "Luiz", "DT_CRIACAO" => "10/11/2020"],
// ]


// --------------------------------------------
// 3 - Atualização de registro no banco. // //
// --------------------------------------------

$tableAdm->where($tableAdm::ID . " = :" . $tableAdm::ID)->update();
// Dessa forma todos os dados do $_REQUEST referentes ao ID informado
// serão atualizados no banco de dado.

$columnsCreate = array($tableAdm::ADM_NAME, $tableAdm::DT_CRIACAO);
$tableAdm->where($tableAdm::DT_CRIACAO . " >= :" . $tableAdm::DT_CRIACAO)->update($columnsCreate);
// Dessa forma apenas os dados do $_REQUEST referentes às colunas informadas
// serão atualizados no banco de dado.

// *** Nos dois casos acima, colunas que não tiverem valor serão inseridas NULL (caso o banco permita). ***

$tableAdm->where("")->update();
$tableAdm->where("")->update($columnsCreate);
// *** É possível dar UPDATE sem WHERE mas não é recomendado. ***


// ---------------------------------------
// 4 - Remoção de registro no banco. // //
// ---------------------------------------

$tableAdm->where($tableAdm::DT_CRIACAO . " >= :" . $tableAdm::DT_CRIACAO)->delete();
// Dessa forma todos os registros com data >= a $_REQUEST[$tableAdm::DT_CRIACAO]
// serão removidos do banco de dado.

$_REQUEST[$tableAdm::ID] = 1;

$tableAdm->where($tableAdm::ID . " = :" . $tableAdm::ID)->delete();
// *** Dessa forma o ORM irá verificar quais valores estão carregados no $_REQUEST para fazer os BINDS. ***

$tableAdm->where("")->delete($_REQUEST[$tableAdm::ID]);
// *** Dessa forma o ORM irá verificar quais valores estão carregados no $_REQUEST para fazer os BINDS. ***
// *** Mas também ira adicinar na no WHERE a seguinte expressão: %TABLE_IDENTIFIER% = :%TABLE_IDENTIFIER%. ***

$tableAdm->where($tableAdm::ID . " = :" . $tableAdm::ID)->delete($_REQUEST[$tableAdm::ID]);
// *** Dessa forma o ORM irá verificar quais valores estão carregados no $_REQUEST para fazer os BINDS. ***
// *** Mas também ira adicinar na no WHERE a seguinte expressão: %TABLE_IDENTIFIER% = :%TABLE_IDENTIFIER%. ***
// *** o ORM verifica se existem condições repetidas no WHERE e as remove deixando apenas uma. ***

$tableAdm->where("")->delete();
// *** É possível dar DELETE sem WHERE mas não é recomendado. ***





// --------------------------------------------------------------------------------
// --------------Carregando dados no obejto sem usar o $_REQUEST.------------------
// --------------------------------------------------------------------------------

// ---------------------------------------
// 1 - Criação de registro no banco. // //
// ---------------------------------------

$data = array($tableAdm::ADM_NAME => "Tiago", $tableAdm::DT_CRIACAO => "10/11/2020");

$tableAdm->setAllData($data);

$tableAdm->create();
// Dessa forma todos os dados informados no $data referentes à essa tabela
// serão inseridos no banco de dado.

$columnsCreate = array($tableAdm::ADM_NAME, $tableAdm::DT_CRIACAO);
$tableAdm->create($columnsCreate);
// Dessa forma apenas os dados informados no $data referentes às colunas informadas
// serão inseridos no banco de dado.

$tableAdm->set_adm_name("Tiago");
$tableAdm->set_dt_criacao("10/11/2020");
// *** O ORM, caso o dev não tenha informado que não, sempre busca dados dentro do objeto filho. ***

$tableAdm->create();
// Dessa forma todos os dados informados inseridos no objeto filho referentes à essa tabela
// serão inseridos no banco de dado.

$columnsCreate = array($tableAdm::ADM_NAME, $tableAdm::DT_CRIACAO);
$tableAdm->create($columnsCreate);
// Dessa forma apenas os dados informados inseridos no objeto filho referentes às colunas informadas
// serão inseridos no banco de dado.

// Todos os casos acima, colunas que não tiverem valor serão inseridas NULL (caso o banco permita).


// ---------------------------------------
// 2.1 - Busca de registro no banco. // //
// -------------Método Find---------------

$tableAdm->set_id(1);

$tableAdm->find($tableAdm->get_id());
// Dessa forma os dados do registro com ID = 1 serão retornado em formato de array nomeado (CHAVE e VALOR).
// EXEMPLO: ["ID" => 1, "ADM_NOME" => "Tiago", "DT_CRIACAO" => "10/11/2020"]

$columnsCreate = array($tableAdm::ADM_NAME, $tableAdm::DT_CRIACAO);
$tableAdm->find($tableAdm->get_id(), $columnsCreate);
// Dessa forma os dados do registro com ID = 1 refentes às colunas informadas
// serão retornado em formato de array nomeado (CHAVE e VALOR).
// EXEMPLO: ["ADM_NOME" => "Tiago", "DT_CRIACAO" => "10/11/2020"]


// ---------------------------------------
// 2.1 - Busca de registro no banco. // //
// -------------Método FindAll------------

$tableAdm->findAll();
// Dessa forma todos os dados serão retornado em formato de matriz (array de array).
// EXEMPLO:
// [
// ["ID" => 1, "ADM_NOME" => "Tiago", "DT_CRIACAO" => "10/11/2020"],
// ["ID" => 2, "ADM_NOME" => "Pedro", "DT_CRIACAO" => "10/11/2020"],
// ["ID" => 3, "ADM_NOME" => "Henrique", "DT_CRIACAO" => "10/11/2020"],
// ["ID" => 4, "ADM_NOME" => "Luiz", "DT_CRIACAO" => "10/11/2020"],
// ]

$columnsCreate = array($tableAdm::ADM_NAME, $tableAdm::DT_CRIACAO);
$tableAdm->findAll($columnsCreate);
// Dessa forma todos os dados refentes às colunas informadas serão retornado em formato
// de array nomeado (CHAVE e VALOR).
// EXEMPLO:
// [
// ["ADM_NOME" => "Tiago", "DT_CRIACAO" => "10/11/2020"],
// ["ADM_NOME" => "Pedro", "DT_CRIACAO" => "10/11/2020"],
// ["ADM_NOME" => "Henrique", "DT_CRIACAO" => "10/11/2020"],
// ["ADM_NOME" => "Luiz", "DT_CRIACAO" => "10/11/2020"],
// ]


// --------------------------------------------
// 3 - Atualização de registro no banco. // //
// --------------------------------------------

$tableAdm->set_id(1);
$tableAdm->set_adm_name("Tiago");
$tableAdm->set_dt_criacao("10/11/2020");
// *** O ORM, caso o dev não tenha informado que não, sempre busca dados dentro do objeto filho. ***

$tableAdm->where($tableAdm::ID . " = :" . $tableAdm::ID)->update();
// Dessa forma todos os dados inseridos no objeto filho referentes ao ID informado
// serão atualizados no banco de dado.

$columnsCreate = array($tableAdm::ADM_NAME);
$tableAdm->where($tableAdm::DT_CRIACAO . " >= :" . $tableAdm::DT_CRIACAO)->update($columnsCreate);
// Dessa forma apenas os dados inseridos no objeto filho referentes às colunas informadas
// serão atualizados no banco de dado.

// *** Nos dois casos acima, colunas que não tiverem valor serão inseridas NULL (caso o banco permita). ***

$tableAdm->where("")->update();
$tableAdm->where("")->update($columnsCreate);
// *** É possível dar UPDATE sem WHERE mas não é recomendado. ***


// ---------------------------------------
// 4 - Remoção de registro no banco. // //
// ---------------------------------------

$tableAdm->set_id(1);
$tableAdm->set_adm_name("Tiago");
$tableAdm->set_dt_criacao("10/11/2020");
// *** O ORM, caso o dev não tenha informado que não, sempre busca dados dentro do objeto filho. ***

$tableAdm->where($tableAdm::DT_CRIACAO . " >= :" . $tableAdm::DT_CRIACAO)->delete();
// Dessa forma todos os registros com data >= a $tableAdm->get_dt_criacao()
// serão removidos do banco de dado.

$tableAdm->set_id(1);
// *** O ORM, caso o dev não tenha informado que não, sempre busca dados dentro do objeto filho. ***

$tableAdm->where($tableAdm::ID . " = :" . $tableAdm::ID)->delete();
// *** Dessa forma o ORM irá verificar quais valores estão carregados no objeto filho para fazer os BINDS. ***

$tableAdm->where("")->delete($tableAdm->get_id());
// *** Dessa forma o ORM irá verificar quais valores estão carregados no objeto filho para fazer os BINDS. ***
// *** Mas também ira adicinar na no WHERE a seguinte expressão: %TABLE_IDENTIFIER% = :%TABLE_IDENTIFIER%. ***

$tableAdm->where($tableAdm::ID . " = :" . $tableAdm::ID)->delete($tableAdm->get_id());
// *** Dessa forma o ORM irá verificar quais valores estão carregados no objeto filho para fazer os BINDS. ***
// *** Mas também ira adicinar na no WHERE a seguinte expressão: %TABLE_IDENTIFIER% = :%TABLE_IDENTIFIER%. ***
// *** o ORM verifica se existem condições repetidas no WHERE e as remove deixando apenas uma. ***

$tableAdm->where("")->delete();
// *** É possível dar DELETE sem WHERE mas não é recomendado. ***
