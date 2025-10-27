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
class MemberByQrCode extends CacheBase
{
    use WithHelpers;

    public function __construct(protected string $qrCode, protected array $relationships = [])
    {
        $implodedRelationships = implode('.', $relationships);
        parent::__construct("members.{$qrCode}.relationships.{$implodedRelationships}", now()->addHour());
    }

    protected function cacheMiss()
    {
        return app(MemberRepositoryInterface::class)->with($this->relationships)->filterByQrCode($this->qrCode)->first();
    }

    protected function errorModelName(): string
    {
        return "Member";
    }

    protected function errorModelId()
    {
        return $this->qrCode;
    }
}
