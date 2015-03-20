<?php
session_start();
require 'vendor/autoload.php';

$app = new \Slim\Slim(
  array('templates.path' => './views')
);

$app->hook('slim.before.dispatch', function () use ($app) {
	$app->render('header.php');
});

$app->hook('slim.after.dispatch', function () use ($app) {
	$app->render('footer.php');
});

$app->get('/', function() use($app) {
  $app->render('index.php');
});

$app->get('/login', function() use($app) {

});

$app->run();
?>
