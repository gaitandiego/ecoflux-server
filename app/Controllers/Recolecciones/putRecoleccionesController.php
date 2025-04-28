<?php

namespace App\Controllers\Recolecciones;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Controllers\Recolecciones\_BaseRecoleccionesController;

class putRecoleccionesController extends _BaseRecoleccionesController
{
    public function __invoke(Request $request, Response $response)
    {
        // Metodo para validar los parametros que llegaron
        $params = $this->getParamsAndValidate($request, [
            'token'  => ['type' => 'string', 'canBeEmpty' => false],
            'id'  => ['type' => 'integer', 'canBeEmpty' => false],
            'id_usuario'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'ruta'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'celular'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'direccion'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
        ]);

        //valida token
        if ($params['token'] !== $this->csrfTokenManager->getCsrfToken()) {
            throw new \Exception('Invalid token', 403);
        }

        // devuelve informacion del service
        $response->getBody()->write(
            json_encode([
                'response' => $this->RecoleccionesService->put($params)
            ])
        );

        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
