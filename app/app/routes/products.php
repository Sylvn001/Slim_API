<?php 
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use App\Models\Product;
// Register routes

$app->group('/api', function (Group $group) {

    $group->get('/products/list', function(Request $request, Response $response){
        $products = json_encode($products = Product::get());
        $response->getBody()->write($products);

        return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(201);
    });

    $group->post('/products/insert', function(Request $request, Response $response){
        $data = $request->getParsedBody();
        $products = json_encode(Product::create($data));
        $response->getBody()->write($products);

        return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(201);
    });

    $group->get('/products/list/{id}', function(Request $request, Response $response, $args){
        $products = json_encode(Product::findOrFail(['id' => $args['id']]));
        $response->getBody()->write($products);

        return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(201);
    });

    $group->post('/products/update/{id}', function(Request $request, Response $response, $args){
        //because put method return null in the id param i used post 
        $product = Product::find(['id' => $args['id']])->first();
        $data = $request->getParsedBody();
      
        $product['title']    =  $data['title'];
        $product['description']    =  $data['description'];
        $product['manufacturer']    =  $data['manufacturer'];
        $product['price']    =  $data['price'];
        $product->save();

        $response->getBody()->write(json_encode($product));

        return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(201);
    });

    $group->get('/products/remove/{id}', function(Request $request, Response $response, $args){
        $product = Product::find(['id' => $args['id']])->first();
        $product->delete();

        $response->getBody()->write(json_encode($product));

        return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus(201);
    });


});