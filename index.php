<?php
session_start();
require 'vendor/autoload.php';

$app = new \Slim\Slim(
  array('templates.path' => './views')
);

$app->get('/', function() use($app) {
  $app->render('index.php');
});

$app->get('/login', function() use($app) {

});

$app->run();
?>
