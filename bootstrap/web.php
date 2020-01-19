<?php

use App\Controllers\HomeController;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/', function (Request $request, Response $response) {
    $controller = new HomeController();

    var_dump($controller);

    die();

})
    ->setName('home');
