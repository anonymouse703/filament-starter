<?php

namespace App\Cache\Member;

use App\Cache\CacheBase;
use App\Cache\WithHelpers;
use App\Models\Member as Model;
use App\Repositories\Contracts\MemberRepositoryInterface;

/**
 * @method Model|null fetch()
 * @method Model fetchOrFail()
 */
class MemberByMobile extends CacheBase
{
    use WithHelpers;

    public function __construct(protected string $mobile)
    {
        parent::__construct("members.{$mobile}", now()->addHour());
    }

    protected function cacheMiss()
    {
        return app(MemberRepositoryInterface::class)->filterByMobile($this->mobile)->first();
    }

    protected function errorModelName(): string
    {
        return "Member";
    }

    protected function errorModelId()
    {
        return $this->mobile;
    }
}
