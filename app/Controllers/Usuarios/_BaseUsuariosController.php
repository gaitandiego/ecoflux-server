<?php
// Creamos el controlador principal
namespace App\Controllers\Usuarios;

// Traemos los archivos necesarios a utilizar
use App\Services\UsuariosService;
use App\Validators\ParamsValidator;
use App\Controllers\_BaseController;
use App\Classes\CsrfTokenManager;

class _BaseUsuariosController extends _BaseController
{
    protected $UsuariosService;
    protected $csrfTokenManager;

    public function __construct(UsuariosService $UsuariosService, ParamsValidator $paramsValidator, CsrfTokenManager $csrfTokenManager)
    {
        // Inyectamos en el construcctor la informacion o metodos que requerimos
        $this->UsuariosService = $UsuariosService;
        $this->csrfTokenManager = $csrfTokenManager;
        parent::__construct($paramsValidator);
    }
}
