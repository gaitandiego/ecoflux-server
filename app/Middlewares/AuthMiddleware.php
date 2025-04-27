<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

use App\Services\LoggedUserService as User;

class AuthMiddleware
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Middleware api
     *
     * @param  $request  PSR7 request
     * @param  callable  $handler handler middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke(Request $request, RequestHandler $handler)
    {
        if ($request->getMethod() !== 'OPTIONS' && !$this->user->getId()) {
            $response = new Response();
            return $response->withStatus(401);
        }

        $response = $handler->handle($request);

        return $response;
    }
}
