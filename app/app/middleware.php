<?php
declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;

use Slim\App;

return function (App $app, $container) {
    $app->add(SessionMiddleware::class);
    
    $app->add(new Tuupola\Middleware\JwtAuthentication([
        "header" => "X-Token",
        "regexp" => "/(.*)/",
        "path" => "/api", /* or ["/api", "/admin"] */
        "ignore" => ["/api/token"],
        "secret" =>  $container->get('settings')['secretKey'],
    ]));

    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

};
