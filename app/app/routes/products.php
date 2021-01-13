<?php 
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

// Register routes

$app->group('/api', function (Group $group) {
    $group->get('/products', function(Request $request, Response $response){
        $response->getBody()->write('Hello products');
        return $response;
    });
});