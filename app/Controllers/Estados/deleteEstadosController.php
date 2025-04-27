<?php

namespace App\Controllers\Estados;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Controllers\Estados\_BaseEstadosController;

class deleteEstadosController extends _BaseEstadosController
{
    public function __invoke(Request $request, Response $response)
    {
        // Metodo para validar los parametros que llegaron
        $params = $this->getParamsAndValidate($request, [
            'token'  => ['type' => 'string', 'canBeEmpty' => false],
            'id'  => ['type' => 'integer', 'canBeEmpty' => false]
        ]);


        // valida token
        if ($params['token'] !== $this->csrfTokenManager->getCsrfToken()) {
            throw new \Exception('Invalid token', 403);
        }

        //devuelve informacion del service
        $response->getBody()->write(
            json_encode([
                'response' => $this->estadosService->delete($params['id']),
            ])
        );

        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
