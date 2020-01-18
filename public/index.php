<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);

$app = AppFactory::create();

$errorMiddleware = new ErrorMiddleware(
    $app->getCallableResolver(),
    $app->getResponseFactory(),
    true,
    false,
    false
);

$app->add($errorMiddleware);

$container->set('hello', function () {
    return 'Hello';
});

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write(
        $this->get('hello')
    );

    return $response;
});

$app->get('/about', function (Request $request, Response $response) {
    $response->getBody()->write('About');

    return $response;
});

$app->run();
