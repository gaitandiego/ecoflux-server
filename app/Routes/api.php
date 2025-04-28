<?php

use Slim\Routing\RouteCollectorProxy;
use App\Middlewares\AuthMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

// crea el endpoint con la ruta de api
$app->group('/api', function (RouteCollectorProxy $app) {
    $app->group('/logged-user', function (RouteCollectorProxy $app) {
        $app->get('/is-logged',  App\Controllers\LoggedUser\isLoggedController::class);
        $app->post('/login', App\Controllers\LoggedUser\loginController::class);
        $app->post('/logout', App\Controllers\LoggedUser\logoutController::class)
            ->add(AuthMiddleware::class);
    });

    $app->group('/usuarios', function (RouteCollectorProxy $app) {
        // habilita el metodo get y utiliza el controller 
        $app->get('', App\Controllers\Usuarios\getUsuariosController::class)
            ->setName('get');
        $app->post('', App\Controllers\Usuarios\postUsuariosController::class)
            ->setName('post');
        $app->put('', App\Controllers\Usuarios\putUsuariosController::class)
            ->setName('put');
        $app->delete('', App\Controllers\Usuarios\deleteUsuariosController::class)
            ->setName('delete');
    });

    $app->group('/recolecciones', function (RouteCollectorProxy $app) {
        // habilita el metodo get y utiliza el controller 
        $app->get('', App\Controllers\Recolecciones\getRecoleccionesController::class)
            ->setName('get');
        $app->post('', App\Controllers\Recolecciones\postRecoleccionesController::class)
            ->setName('post');
        $app->put('', App\Controllers\Recolecciones\putRecoleccionesController::class)
            ->setName('put');
        $app->delete('', App\Controllers\Recolecciones\deleteRecoleccionesController::class)
            ->setName('delete');
    });


    $app->get('/[{path:.*}]', function (Request $request, Response $response, $args) {
        $response->getBody()->write('Route not found');

        return $response->withStatus(404);
    });
});
