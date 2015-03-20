<?php
session_start();
require 'vendor/autoload.php';

$app = new \Slim\Slim();

$app->get('/login', function() use($app) {
  echo 'hello world';
});

$app->run();
?>
