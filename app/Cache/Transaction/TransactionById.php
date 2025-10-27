<?php

namespace App\Cache\Transaction;

use App\Cache\CacheBase;
use App\Cache\WithHelpers;
use App\Models\Transaction as Model;
use App\Repositories\Contracts\TransactionRepositoryInterface;

/**
 * @method Model|null fetch()
 * @method Model fetchOrFail()
 */
class TransactionById extends CacheBase
{
    use WithHelpers;

    public function __construct(protected int $id)
    {
        parent::__construct("transactions.{$id}", now()->addHour());
    }

    protected function cacheMiss()
    {
        return app(TransactionRepositoryInterface::class)->find($this->id);
    }

    protected function errorModelName(): string
    {
        return "transaction";
    }

    protected function errorModelId()
    {
        return $this->id;
    }
}
