<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceModeException extends Exception
{
    protected $code = Response::HTTP_SERVICE_UNAVAILABLE;

    public function __construct(string $message = "System under maintenance.", \Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }
}
