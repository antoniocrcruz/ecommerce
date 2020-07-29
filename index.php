<?php 

require_once("vendor/autoload.php");

$app = new \Slim\Slim();

$app->config('debug', true);// debug, todo erro ele mostra o que houve
// criar uma rota principal
$app->get('/', function() {
    
	$sql = new HCode\DB\Sql();

	$results = $sql->select("SELECT * FROM tb_users");

	echo json_encode($results);
});

//roda o projeto
$app->run();

 ?>