<?php

use Slim\Factory\AppFactory;
use DI\Container;
use Slim\Views\Twig;

$container = new Container();
AppFactory::setContainer($container);

// Set view in Container
$container->set('view', function () {
    return Twig::create('views', [
        'cache' => false
    ]);
});
