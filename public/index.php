<?php

use DI\Container;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

require 'vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);

// Set view in Container
$container->set('view', function () {
    return Twig::create('views', [
        'cache' => false
    ]);
});

// Create App
$app = AppFactory::create();

// Middlewares
// 1. ErrorMiddleware
$errorMiddleware = new ErrorMiddleware(
    $app->getCallableResolver(),
    $app->getResponseFactory(),
    true,
    false,
    false
);

$app->add($errorMiddleware);

// 2. TwigMiddleware
$app->add(TwigMiddleware::createFromContainer($app));

// Routing
$app->get('/', function (Request $request, Response $response) {
    $users = [
        'alex',
        'billy',
        'dale'
    ];
    return $this->get('view')->render($response, 'home.twig', compact('users'));
})
    ->setName('home');
$app->get('/about', function (Request $request, Response $response) {
    $users = [
        'alex',
        'billy',
        'dale'
    ];
    return $this->get('view')->render($response, 'about.twig', compact('users'));
})
    ->setName('about');

// Running App
$app->run();
