<?php

namespace App\Controllers\Estados;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Controllers\Estados\_BaseEstadosController;

class getEstadosController extends _BaseEstadosController
{
    public function __invoke(Request $request, Response $response)
    {
        // Metodo para validar los parametros 
        $params = $this->getParamsAndValidate($request, [
            'token'  => ['type' => 'string', 'canBeEmpty' => false],
            'tipo'  => ['type' => 'string', 'canBeEmpty' => true]
        ]);

        // valida que el token sea correcto
        if ($params['token'] !== $this->csrfTokenManager->getCsrfToken()) {
            throw new \Exception('Invalid token', 403);
        }
        //devuelve informacion del service
        $response->getBody()->write(
            json_encode([
                'response' => $this->estadosService->get($params['tipo']),
            ])
        );

        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
