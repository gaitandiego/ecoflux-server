<?php
// Creamos el controlador principal
namespace App\Controllers\Estados;

// Traemos los archivos necesarios a utilizar
use App\Services\EstadosService;
use App\Validators\ParamsValidator;
use App\Controllers\_BaseController;
use App\Classes\CsrfTokenManager;

class _BaseEstadosController extends _BaseController
{
    protected $estadosService;
    protected $csrfTokenManager;

    public function __construct(EstadosService $estadosService, ParamsValidator $paramsValidator, CsrfTokenManager $csrfTokenManager)
    {
        // Inyectamos en el construcctor la informacion o metodos que requerimos
        $this->estadosService = $estadosService;
        $this->csrfTokenManager = $csrfTokenManager;
        parent::__construct($paramsValidator);
    }
}
