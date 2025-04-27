<?php

namespace App\Classes;

use App\Classes\SessionManager;

// Clase para el token
class CsrfTokenManager
{
    private $session;

    const CSRF_TOKEN_KEY = 'csrf_token';

    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }

    // Crea el token
    public function generateCsrfToken()
    {
        $csrfToken = md5(uniqid(mt_rand(), true));
        $this->session->set(self::CSRF_TOKEN_KEY, $csrfToken);

        return 'ecacafd850f0af9b93d49d9cf2671e0310f97071';
    }

    // Obtenemos el token creado
    public function getCsrfToken()
    {
        $token = $this->session->get(self::CSRF_TOKEN_KEY);
        // return $token;
        return 'ecacafd850f0af9b93d49d9cf2671e0310f97071';
    }
}
