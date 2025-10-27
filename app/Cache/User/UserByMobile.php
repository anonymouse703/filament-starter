<?php

namespace App\Cache\User;

use App\Cache\CacheBase;
use App\Cache\WithHelpers;
use App\Models\User as Model;
use App\Repositories\Contracts\UserRepositoryInterface;

/**
 * @method Model|null fetch()
 * @method Model fetchOrFail()
 */
class UserByMobile extends CacheBase
{
    use WithHelpers;

    public function __construct(protected string $mobile)
    {
        parent::__construct("users.{$mobile}", now()->addHour());
    }

    protected function cacheMiss()
    {
        return app(UserRepositoryInterface::class)->filterByMobile($this->mobile)->first();
    }

    protected function errorModelName(): string
    {
        return "User";
    }

    protected function errorModelId()
    {
        return $this->mobile;
    }
}
