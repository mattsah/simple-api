<?php

$routes->addRoute('GET',  '/api/v1/users/', 'ListUsers');
$routes->addRoute('POST', '/api/v1/users/', 'CreateUser');
$routes->addRoute('GET',  '/api/v1/users/{id:[0-9]+}', 'SelectUser');
