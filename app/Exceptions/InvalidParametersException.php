<?php

namespace App\Exceptions;

class InvalidParametersException extends \Exception
{
    private $extraParams;

    public function __construct($message, $code = 0, $extraParams = [])
    {
        $this->extraParams = $extraParams;
        parent::__construct($message, $code);
    }
    public function getExtraParams()
    {
        return $this->extraParams;
    }
}
