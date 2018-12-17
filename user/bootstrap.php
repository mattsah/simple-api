<?php

$injector = new Auryn\Injector();

//
// Aliases
//


$injector->alias('FastRoute\RouteParser', 'FastRoute\RouteParser\Std');
$injector->alias('FastRoute\DataGenerator', 'FastRoute\DataGenerator\GroupCountBased');
$injector->alias('FastRoute\Dispatcher', 'FastRoute\Dispatcher\GroupCountBased');

$injector->alias('Psr\Http\Message\ServerRequestInterface', 'Zend\Diactoros\ServerRequest');
$injector->alias('Psr\Http\Message\ResponseInterface', 'Zend\Diactoros\Response');
$injector->alias('Psr\Http\Message\StreamInterface', 'Zend\Diactoros\Stream');

//
// Delegates
//

$injector->delegate('Zend\Diactoros\ServerRequest', function() {
    return Zend\Diactoros\ServerRequestFactory::fromGlobals(
        $_SERVER,
        $_GET,
        $_POST,
        $_COOKIE,
        $_FILES 
    );
});

$injector->delegate('Zend\Diactoros\Response', function(Zend\Diactoros\Stream $stream) {
    return Zend\Diactoros\ResponseFactory::createResponse(404)->withBody($stream);
});


$injector->delegate('Zend\Diactoros\Stream', function() {
    return new Zend\Diactoros\Stream('php://temp', 'wb+');
});

$injector->delegate('FastRoute\Dispatcher\GroupCountBased', function(FastRoute\RouteCollector $routes) {
    return new FastRoute\Dispatcher\GroupCountBased($routes->getData());
});


$injector->prepare('FastRoute\RouteCollector', function($routes) {
    include('../user/routes.php');

    return $routes;
});

$injector->delegate('Users', function() {
    return new Users(__DIR__ . '/../data/users.json');
});

$injector->share($injector);

return $injector;