<?php
session_start();
require 'vendor/autoload.php'; // Include Composer's autoloader
use Slim\Middleware\MethodOverrideMiddleware;

use \Slim\Slim;

use Hcode\Page;
use Hcode\PageAdmin;
use Hcode\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function () {
    $page = new Page();
    $page->setTpl("index");
});

$app->get('/admin/', function () use ($app) {
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("index");
});

$app->get('/admin/login/', function () {
   $page = new PageAdmin([
       "header" => false,
       "footer" => false
   ]);
   $page->setTpl("login");
});

$app->POST('/admin/login/', function () use ($app) {
   $request = $app->request(); // Obter a requisição HTTP
   $login = $request->post('login'); // Obter o valor do campo 'login' enviado no formulário
   $password = $request->post('password'); // Obter o valor do campo 'password' enviado no formulário
   
   // Verificar se ambos os campos foram enviados
   if (!empty($login) && !empty($password)) {
       // Tente fazer o login
       try {
           User::login($login, $password);
           // Redirecionar para a página de administração após o login bem-sucedido
           $app->redirect('/ecommerce/admin/');
       } catch (\Exception $e) {
           // Em caso de falha no login, redirecionar para a página de login com uma mensagem de erro
           $app->flash('error', $e->getMessage());
           $app->redirect('/ecommerce/admin/login/');
       }
   } else {
       // Em caso de campos em branco, redirecionar para a página de login com uma mensagem de erro
       $app->flash('error', 'Login and password are required.');
       $app->redirect('/ecommerce/admin/login/');
   }
   exit;
});

$app->get('/admin/logout/', function(){
    User::logout();
    header("Location: /ecommerce/admin/login/");
    exit;
});

$app->run();



