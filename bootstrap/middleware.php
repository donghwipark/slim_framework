<?php

use Slim\Middleware\ErrorMiddleware;
use Slim\Views\TwigMiddleware;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


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
// $app->get('/', function (Request $request, Response $response) {
//     return $this->get('view')->render($response, 'home.twig', compact('users'));
// })
//     ->setName('home');

$app->get('/users/{username}', function (Request $request, Response $response, $args) {
    return $this->get('view')->render($response, 'profile.twig', [
        'username' => $args['username']
    ]);
});

$app->get('/users/{username}/posts/{id}', function (Request $request, Response $response, $args) {
    return $this->get('view')->render($response, 'posts.twig', [
        'username' => $args['username'],
        'id' => $args['id']
    ]);
});

$app->get('/one', function (Request $request, Response $response, $args) use ($app) {
    return $response
        ->withHeader('Location', '/two')
        ->withStatus(302);
})
    ->setName('one');

$app->get('/two', function (Request $request, Response $response) {
    $response->getBody()->write('Two');
    return $response;
})
    ->setName('two');;

$app->get('/about', function (Request $request, Response $response) {
    $users = [
        'alex',
        'billy',
        'dale'
    ];
    return $this->get('view')->render($response, 'about.twig', compact('users'));
})
    ->setName('about');

$app->get('/json', function (Request $request, Response $response) {
    $data = [
        'alex',
        'billy',
        'dale'
    ];

    $response->getBody()->write(json_encode($data));

    return $response
    ->withHeader('Content-Type', 'application/json');
});


$app->get('/contact', function (Request $request, Response $response) {
    return $this->get('view')->render($response, 'contact.twig', compact('users'));
})
    ->setName('contact');

$app->post('/contact', function (Request $request, Response $response) {
    $data = $request->getParsedBody();

    $response->getBody()->write($data['name']);

    return $response;
})
    ->setName('contact');
