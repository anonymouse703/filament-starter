<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class MobileNotFoundException extends Exception
{
    protected $code = Response::HTTP_NOT_FOUND;

    public function __construct(
        string $message = "Number not found. Used your registered mobile number.",
        \Throwable $previous = null
    ) {
        parent::__construct($message, $this->code, $previous);
    }

    public function render($request)
    {
        return response()->json([
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'success' => false,
        ], $this->getCode());
    }
}
