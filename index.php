<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/app/config/autoloads/autoload_default.php";

$conexao = config\conexoes\ConexaoOracle::getInstance();

// $this->add_sq_binds();
use core\classes\abstracts\ModelDAO;

$connect = new ModelDAO();


$query = "INSERT INTO TL.USERS (NAME, EMAIL, PASSWORD) VALUES (:NAME, :EMAIL, :PASSWORD)";

// $data = $connect->pdo->prepare($query);

// var_dump($data->execute([":NAME" => "Tiago", ":EMAIL" => "asdsa@silva.br", ":PASSWORD" => "123"]));
// var_dump($data->rowCount());

// var_dump("<br>");

$data = $connect->pdo->prepare("SELECT * FROM TL.USERS WHERE ID = (SELECT MAX(ID) FROM TL.USERS)");
$data->execute();

var_dump($data->fetch(PDO::FETCH_OBJ));




// if (isset($conexao)) {
//     require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/home/page/home.php");
// }