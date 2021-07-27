<?php

session_start();//certeza que a sessão está rodando no servidor

require_once("vendor/autoload.php");

use \Slim\Slim;
use \antoniocrcruz\Page;
use \antoniocrcruz\PageAdmin;
use \antoniocrcruz\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page(); //chama o header
	
	$page->setTpl("index"); //adiciona a página do corpo, após ele limpa a memória e carrega o destruct/arquivo footer.html

});

$app->get('/admin', function() {
    
	User::verifyLogin();

	$page = new PageAdmin(); //chama o header
	
	$page->setTpl("index"); //adiciona a página do corpo, após ele limpa a memória e carrega o destruct/arquivo footer.html. Função setTpl chama o template específico para a rota, nesse caso "index"

});

$app->get('/admin/login', function() {
    
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false

	]); //chama o header
	
	$page->setTpl("login"); //adiciona a página do corpo, após ele limpa a memória e carrega o destruct/arquivo footer.html, após encerrar a execução do método

});

$app->post('/admin/login', function() {
    
	User::login($_POST['login'], $_POST['password']);//classe User para validar login e senha, com o método estático "login"

	header("Location: /admin");
	exit;


});

$app->get('/admin/logout', function() {
    
	User::logout();

	header("Location: /admin/login");
	exit;
});

$app->run();

 ?>