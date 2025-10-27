<?php

namespace App\Cache\PersonalAccessToken;

use App\Cache\CacheBase;
use App\Models\Sanctum\PersonalAccessToken;

class Token extends CacheBase
{
    public function __construct(protected int $id)
    {
        parent::__construct("tokens.{$id}", now()->addHour());
    }

    public function cacheMiss()
    {
        return PersonalAccessToken::find($this->id);
    }

    public function errorModelName(): string
    {
        return "PersonalAccessToken";
    }

    public function errorModelId()
    {
        return $this->id;
    }
}
