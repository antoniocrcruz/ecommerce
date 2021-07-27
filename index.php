<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;
use \antoniocrcruz\Page;
use \antoniocrcruz\PageAdmin;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page(); //chama o header
	
	$page->setTpl("index"); //adiciona a página do corpo, após ele limpa a memória e carrega o destruct/arquivo footer.html

});

$app->get('/admin', function() {
    
	$page = new PageAdmin(); //chama o header
	
	$page->setTpl("index"); //adiciona a página do corpo, após ele limpa a memória e carrega o destruct/arquivo footer.html

});

$app->run();

 ?>