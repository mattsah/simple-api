<?php

use FastRoute\Dispatcher;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Narrowspark\HttpEmitter\SapiEmitter as Emitter;

$loader   = require('../vendor/autoload.php');
$injector = require('../user/bootstrap.php');

exit($injector->execute(function(Dispatcher $dispatcher, Request $request, Emitter $emitter, Response $response) use ($injector) {
    $route = $dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

    switch($route[0]) {
        case FastRoute\Dispatcher::NOT_FOUND:
            $response = $response->withStatus(404);
            break;

        case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
            $response = $response->withStatus(403)->withHeader('Allowed', join(',', $route[1]));
            break;

        case FastRoute\Dispatcher::FOUND:
            $params  = array();
            $handler = $route[1];

            foreach ($route[2] as $name => $value) {
                $params[':' . $name] = $value;
            }

            try {
                $action = $injector->make($handler);

                if (!$action instanceof ResponderInterface) {
                    throw new RuntimeException('Cannot execute handler, not a responder');
                }

                if (!is_callable($action)) {
                    throw new RuntimeException('Cannot execute handler, not callable');
                }
    
                $action->setResponse($response);
                $action->setRequest($request);
    
                $response = $injector->execute($action, $params);

            } catch (Exception $e) {
                throw $e;
                $response = $response->withStatus(500);
            }
    }

    $emitter->emit($response);

    return $response->getStatusCode();
}));
