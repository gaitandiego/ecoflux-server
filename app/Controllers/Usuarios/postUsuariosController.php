<?php
// crear controlador que es el encargado de validar 
namespace App\Controllers\Usuarios;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Controllers\Usuarios\_BaseUsuariosController;

class postUsuariosController extends _BaseUsuariosController
{

    public function __invoke(Request $request, Response $response)
    {
        // Metodo para validar los parametros 
        $params = $this->getParamsAndValidate($request, [
            'token'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'nombre_usuario'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'password'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'email'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'empresa'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'rol'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
        ]);

        // validar token
        if ($params['token'] !== $this->csrfTokenManager->getCsrfToken()) {
            throw new \Exception('Invalid token', 403);
        }

        // responde lo que envia el service 
        $response->getBody()->write(
            json_encode([
                'response' => $this->UsuariosService->post($params),
            ])
        );

        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
