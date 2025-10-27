<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class LimiterException extends Exception
{
    public function __construct($message = '', $code = 0, Throwable $previous = null, protected ?int $remaining = null, protected ?int $availableIn = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getRemaining(): ?int
    {
        return $this->remaining;
    }

    public function getAvailableIn(): ?int
    {
        return $this->availableIn;
    }
}
