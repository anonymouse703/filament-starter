<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class MemberNotFoundException extends Exception
{
    protected $code = Response::HTTP_NOT_FOUND;

    public function __construct(string $message = "Member Not Found.", \Throwable $previous = null)
    {
        parent::__construct($message, $this->code, $previous);
    }
}
