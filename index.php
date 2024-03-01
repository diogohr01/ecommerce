<?php

require 'vendor/autoload.php'; // Include Composer's autoloader


use \Slim\Slim;

use Hcode\Page;
use Hcode\PageAdmin;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function () {

 /*   $sql = new Hcode\DB\Sql();

    $results = $sql->select("SELECT * FROM tb_users");

    echo json_encode($results);*/

    $page = new Page();

   $page->setTpl("index");


 
});

$app->get('/admin/', function () {

    /*   $sql = new Hcode\DB\Sql();
   
       $results = $sql->select("SELECT * FROM tb_users");
   
       echo json_encode($results);*/
   
       $page = new PageAdmin();
   
      $page->setTpl("index");
   
   
    
   });





$app->run();
    