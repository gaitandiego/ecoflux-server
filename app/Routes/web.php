<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Exceptions\NuxtBuildMissingException;

// PRIMERO: rutas específicas
$app->get('/6f3bda1245cdfe506abd79e8377a6356', function (Request $request, Response $response, $args) {
    $response->getBody()->write(json_encode([
        getenv()
    ]));

    return $response->withHeader('Content-Type', 'application/json');
});

// DESPUÉS: la ruta genérica
$app->get('/[{path:.*}]', function (Request $request, Response $response, $args) {
    $page = @file_get_contents(__DIR__ . "/../../reactapp/index.html");
    if (!$page) {
        throw new NuxtBuildMissingException('Nuxt build missing.');
    }
    $response->getBody()->write($page);

    return $response;
});
