<?php

namespace App\Cache\Purchase;

use App\Cache\CacheBase;
use App\Cache\WithHelpers;
use App\Models\Purchase as Model;
use App\Repositories\Contracts\PurchaseRepositoryInterface;

/**
 * @method Model|null fetch()
 * @method Model fetchOrFail()
 */
class PurchaseById extends CacheBase
{
    use WithHelpers;

    public function __construct(protected int $id)
    {
        parent::__construct("purchases.{$id}", now()->addHour());
    }

    protected function cacheMiss()
    {
        return app(PurchaseRepositoryInterface::class)->find($this->id);
    }

    protected function errorModelName(): string
    {
        return "Purchase";
    }

    protected function errorModelId()
    {
        return $this->id;
    }
}
