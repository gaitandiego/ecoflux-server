<?php
namespace App\Controllers\LoggedUser;

use App\Services\LoggedUserService;
use App\Controllers\_BaseController;
use App\Classes\CsrfTokenManager;
use App\Validators\ParamsValidator;

class _BaseLoggedUserController extends _BaseController 
{

    protected $loggedUserService;
    protected $csrfTokenManager;
    
    public function __construct(LoggedUserService $loggedUserService, CsrfTokenManager $csrfTokenManager, ParamsValidator $paramsValidator)
    {
        $this->loggedUserService = $loggedUserService;
        $this->csrfTokenManager = $csrfTokenManager;
        parent::__construct($paramsValidator);
    }
}