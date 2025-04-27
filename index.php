<?php

use Slim\Factory\AppFactory;
use Selective\BasePath\BasePathMiddleware;
use App\Exceptions\Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

require __DIR__ . '/vendor/autoload.php';

// Crear container
$container = new DI\Container();

// Crear aplicación Slim
AppFactory::setContainer($container);
$app = AppFactory::create();

// Middleware BasePath
$app->add(new BasePathMiddleware($app));

// Primero, cargar dependencias
require __DIR__ . '/app/dependencies.php';

// Agregar el CorsMiddleware

// Rutas
require __DIR__ . '/app/Routes/api.php';
require __DIR__ . '/app/Routes/web.php';

// Middleware de ruteo
$app->addRoutingMiddleware();

// Middleware de errores
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler(new Handler());

// This CORS middleware will append the response header
// Access-Control-Allow-Methods with all allowed methods
$app->add(function (ServerRequestInterface $request, RequestHandlerInterface $handler) use ($app): ResponseInterface {
    if ($request->getMethod() === 'OPTIONS') {
        $response = $app->getResponseFactory()->createResponse();
    } else {
        $response = $handler->handle($request);
    }

    $response = $response
        ->withHeader('Access-Control-Allow-Credentials', 'true')
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', '*')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
        ->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->withHeader('Pragma', 'no-cache');

    if (ob_get_contents()) {
        ob_clean();
    }

    return $response;
});


// Ejecutar app
$app->run();
