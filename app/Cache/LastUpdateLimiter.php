<?php

namespace App\Cache;

class LastUpdateLimiter extends CacheBase
{
    public function __construct(protected string $identifier, $ttl)
    {
        parent::__construct("lastupdatelimiter.{$identifier}", now()->addSeconds($ttl));
    }

    public function cacheMiss()
    {
        return null;
    }

    public function errorModelName(): string
    {
        return "LastUpdateLimiter";
    }

    public function errorModelId()
    {
        return $this->identifier;
    }
}
