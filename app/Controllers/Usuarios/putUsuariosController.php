<?php

namespace App\Controllers\Usuarios;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Controllers\Usuarios\_BaseUsuariosController;

class putUsuariosController extends _BaseUsuariosController
{
    public function __invoke(Request $request, Response $response)
    {
        // Metodo para validar los parametros que llegaron
        $params = $this->getParamsAndValidate($request, [
            'token'  => ['type' => 'string', 'canBeEmpty' => false],
            'id'  => ['type' => 'integer', 'canBeEmpty' => false],
            'nombre_usuario'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'password'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'email'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'empresa'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
            'rol'  => ['type' => 'stringAndInteger', 'canBeEmpty' => false],
        ]);

        //valida token
        if ($params['token'] !== $this->csrfTokenManager->getCsrfToken()) {
            throw new \Exception('Invalid token', 403);
        }

        // devuelve informacion del service
        $response->getBody()->write(
            json_encode([
                'response' => $this->UsuariosService->put($params)
            ])
        );

        return $response->withHeader('Content-Type', 'application/json; charset=utf-8');
    }
}
