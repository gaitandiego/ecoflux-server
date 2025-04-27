<?php

use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Psr7\Factory\ResponseFactory; // <-- Importar la implementación real
use Slim\Interfaces\CallableResolverInterface;
use Slim\Routing\RouteParser;

use App\Classes\SessionManager;
use App\Classes\CsrfTokenManager;
use App\Validators\ParamsValidator;

// Aquí inyectamos la implementación de la interfaz
$container->set(ResponseFactoryInterface::class, function () {
    return new ResponseFactory();
});

$container->set(SessionManager::class, function () {
    return new SessionManager();
});

$container->set(CsrfTokenManager::class, function ($container) {
    return new CsrfTokenManager($container->get(SessionManager::class));
});

$container->set(ParamsValidator::class, function () {
    return new ParamsValidator();
});
