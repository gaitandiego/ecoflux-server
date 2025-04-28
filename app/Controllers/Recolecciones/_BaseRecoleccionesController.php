<?php
// Creamos el controlador principal
namespace App\Controllers\Recolecciones;

// Traemos los archivos necesarios a utilizar
use App\Services\RecoleccionesService;
use App\Validators\ParamsValidator;
use App\Controllers\_BaseController;
use App\Classes\CsrfTokenManager;

class _BaseRecoleccionesController extends _BaseController
{
    protected $RecoleccionesService;
    protected $csrfTokenManager;

    public function __construct(RecoleccionesService $recoleccionesService, ParamsValidator $paramsValidator, CsrfTokenManager $csrfTokenManager)
    {
        // Inyectamos en el construcctor la informacion o metodos que requerimos
        $this->RecoleccionesService = $recoleccionesService;
        $this->csrfTokenManager = $csrfTokenManager;
        parent::__construct($paramsValidator);
    }
}
