<?php

namespace App\Cache;

use Laravel\Sanctum\PersonalAccessToken;


class ApiToken extends CacheBase
{
    public function __construct(protected string $hashedToken)
    {
        parent::__construct("personal_access_tokens.{$hashedToken}", now()->addMinutes(5));

        $this->hashedToken = $hashedToken;
    }

    public function cacheMiss()
    {
       return PersonalAccessToken::where('token', $this->hashedToken)->first();
    }

    public function errorModelName(): string
    {
        return "PersonalAccessToken";
    }

    public function errorModelId()
    {
        return $this->hashedToken;
    }
}
