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
class MemberById extends CacheBase
{
    use WithHelpers;

    public function __construct(protected int $id)
    {
        parent::__construct("members.{$id}", now()->addHour());
    }

    protected function cacheMiss()
    {
        return app(MemberRepositoryInterface::class)->with(['memberPhoto'])->find($this->id);
    }

    protected function errorModelName(): string
    {
        return "member";
    }

    protected function errorModelId()
    {
        return $this->id;
    }
}
