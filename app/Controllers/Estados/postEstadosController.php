<?php
// crear controlador que es el encargado de validar 
namespace App\Controllers\Estados;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Controllers\Estados\_BaseEstadosController;

class postEstadosController extends _BaseEstadosController
{

    public function __invoke(Request $request, Response $response)
    {
        // Metodo para validar los parametros 
        $params = $this->getParamsAndValidate($request, [
            'token'  => ['type' => 'string', 'canBeEmpty' => false],
            'nombre'  => ['type' => 'string', 'canBeEmpty' => false],
            'color'  => ['type' => 'string', 'canBeEmpty' => false],
            'tipo'  => ['type' => 'string', 'canBeEmpty' => false],
        ]);

        // validar token
        if ($params['token'] !== $this->csrfTokenManager->getCsrfToken()) {
            throw new \Exception('Invalid token', 403);
        }

        // responde lo que envia el service 
        $response->getBody()->write(
            json_encode([
                'response' => $this->estadosService->post($params['nombre'], $params['color'], $params['tipo']),
            ])
        );

        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
