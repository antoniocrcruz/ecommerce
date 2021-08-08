<?php

session_start();//certeza que a sessão está rodando no servidor

require_once("vendor/autoload.php");

use \Slim\Slim;
use \antoniocrcruz\Page;
use \antoniocrcruz\PageAdmin;
use \antoniocrcruz\Model\User;
use \antoniocrcruz\Model\Category;

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

$app->get('/admin/users', function(){
	
	User::verifyLogin();

	$users = User::listAll();

	$page = new PageAdmin();

	$page->setTpl("users", array(
		"users"=>$users
	));
});

$app->get('/admin/users/create', function(){
	
	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("users-create");
});

$app->get("/admin/users/:iduser/delete", function($iduser){//se o /delete estivesse embaixo da rota /:iduser, o slim framework não interpretaria o delete, uma vez que ele entenderia a raiz e pararia a execução sem interpretar a rota /delete
	
	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$user->delete();

	header("Location:/admin/users");
	exit;
});

$app->get("/admin/users/:iduser", function($iduser) {//colocamos $iduser como parâmetro obrigatório de rota para que o sistema entenda que queremos atualizar, apenas aquele user especifico

	User::verifyLogin();
	
	$user = new User();

	$user->get((int)$iduser);

	$page = new PageAdmin();

	$page->setTpl("users-update", array(

		"user"=>$user->getValues()
	));
});

$app->post("/admin/users/create", function(){
	
	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0; 

	$user->setData($_POST);

	$user->save();

	header("Location:/admin/users");
	exit;

});

$app->post("/admin/users/:iduser", function($iduser){
	
	User::verifyLogin();

	$user = new User();

	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;

	$user->get((int)$iduser);//carrega dados do banco

	$user->setData($_POST);
	
	$user->update();//-> chama método, => atribui valor
	
	header("Location:/admin/users");
	exit;
});


$app->get("/admin/categories", function() {

	User::verifyLogin();
    
	$categories = Category::listAll();

	$page = new PageAdmin(); //chama o header
	
	$page->setTpl("categories", [
		'categories'=>$categories
	]); //adiciona a página do corpo, após ele limpa a memória e carrega o destruct/arquivo footer.html, após encerrar a execução do método

});

$app->get("/admin/categories/create", function() {
    
	User::verifyLogin();

	$page = new PageAdmin(); //chama o header
	
	$page->setTpl("categories-create"); //adiciona a página do corpo, após ele limpa a memória e carrega o destruct/arquivo footer.html, após encerrar a execução do método

});

$app->post("/admin/categories/create", function() {
    
	User::verifyLogin();

	$category = new Category();

	$category->setData($_POST);

	$category->save();

	header("Location:/admin/categories");
	exit;

});

$app->get("/admin/categories/:idcategory/delete", function($idcategory) {
    
	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->delete();

	header("Location:/admin/categories");
	exit;
});

$app->get("/admin/categories/:idcategory", function($idcategory) {
    
	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl("categories-update", [
		'category'=>$category->getValues()//passa para o template o objeto convertido para um array
	]);
});

$app->post("/admin/categories/:idcategory", function($idcategory) {
    
    User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$category->save();

	header("Location: /admin/categories");
	exit;
});

$app->run();

 ?>