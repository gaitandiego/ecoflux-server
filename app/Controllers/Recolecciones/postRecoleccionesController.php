<?php
// crear controlador que es el encargado de validar 
namespace App\Controllers\Recolecciones;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Controllers\Recolecciones\_BaseRecoleccionesController;

class postRecoleccionesController extends _BaseRecoleccionesController
{

    public function __invoke(Request $request, Response $response)
    {
        // Metodo para validar los parametros 
        $params = $this->getParamsAndValidate($request, [
            'token'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'id_usuario'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'ruta'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'celular'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'direccion'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
        ]);

        // validar token
        if ($params['token'] !== $this->csrfTokenManager->getCsrfToken()) {
            throw new \Exception('Invalid token', 403);
        }

        // responde lo que envia el service 
        $response->getBody()->write(
            json_encode([
                'response' => $this->RecoleccionesService->post($params),
            ])
        );

        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
