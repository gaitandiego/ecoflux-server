<?php

namespace App\Exceptions;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use App\Exceptions\NuxtBuildMissingException;
use App\Exceptions\InvalidParametersException;

class Handler
{
    public function __invoke(
        Request $request,
        \Throwable $e,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ) {
        $response = new Response();
        $contentType = 'application/json'; // valor por defecto

        if ($e instanceof NuxtBuildMissingException) {
            $response->getBody()->write("
                <div>
                    <h1 style='text-align: center;'>Nuxt build missing</h1>
                    <h3 style='text-align: center;'>Execute make node-build</h3>
                </div>
            ");
            $contentType = 'text/html'; // aquí sí queremos HTML
        } else if ($e instanceof InvalidParametersException) {
            $response->getBody()->write(
                json_encode([
                    "message" => $e->getMessage(),
                    "errors" => $e->getExtraParams()
                ])
            );
        } else {
            $response->getBody()->write(
                json_encode([
                    "error" => $e->getMessage(),
                    "errorTrace" => explode("\n", $e->__toString()),
                ])
            );
        }

        $code = $e->getCode() ?: 500;

        return $response->withStatus($code)->withHeader('Content-Type', $contentType);
    }
}
