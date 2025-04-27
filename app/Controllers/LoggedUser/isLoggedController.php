<?php

namespace App\Controllers\LoggedUser;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Controllers\LoggedUser\_BaseLoggedUserController;

class isLoggedController extends _BaseLoggedUserController
{
    public function __invoke(Request $request, Response $response)
    {
        $response->getBody()->write(
            json_encode([
                'isLogged' => $this->loggedUserService->isLogged(),
                // generate csrf token for login
                'token' => $this->csrfTokenManager->generateCsrfToken()
            ])
        );

        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
