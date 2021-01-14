<?php 
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use \Firebase\JWT\JWT;
use App\Models\User;

$app->post('/api/login', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;

    $user = User::where('email', $email)->first();

    if(!is_null($user) && (md5($password) == $user->password) ){
        //create token
        $secretKey = $this->get('settings')['secretKey'];
        $accessKey = JWT::encode($user, $secretKey);

        $response->getBody()->write(json_encode(["key" => $accessKey]));

        return $response
        ->withHeader('Content-Type', 'application/json');
    }

    $response->getBody()->write(json_encode(["status" => "erro"]));

    return $response
    ->withHeader('Content-Type', 'application/json');
});
