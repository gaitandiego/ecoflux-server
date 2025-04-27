<?php

namespace App\Controllers\LoggedUser;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Controllers\LoggedUser\_BaseLoggedUserController;

class loginController extends _BaseLoggedUserController
{
    public function __invoke(Request $request, Response $response)
    {
        $params = $this->getParamsAndValidate($request, [
            'email'     => ['type' => 'string', 'canBeEmpty' => false],
            'password'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
        ]);


        $response->getBody()->write(
            json_encode([
                'user_info' => $this->loggedUserService->login($params['email'], $params['password']),
                'token' => $this->csrfTokenManager->generateCsrfToken()
            ])
        );


        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
