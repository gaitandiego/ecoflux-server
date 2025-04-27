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

    $app->group('/estados', function (RouteCollectorProxy $app) {
        // habilita el metodo get y utiliza el controller de getEmpresas
        $app->get('', App\Controllers\Estados\getEstadosController::class)
            ->setName('get');
        $app->post('', App\Controllers\Estados\postEstadosController::class)
            ->setName('post');
        $app->post('/editar', App\Controllers\Estados\putEstadosController::class)
            ->setName('put');
        $app->delete('', App\Controllers\Estados\deleteEstadosController::class)
            ->setName('delete');
    });

    $app->get('/[{path:.*}]', function (Request $request, Response $response, $args) {
        $response->getBody()->write('Route not found');

        return $response->withStatus(404);
    });
});
