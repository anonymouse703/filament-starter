<?php

namespace App\Cache\Transaction;

use App\Cache\CacheBase;
use App\Cache\WithHelpers;
use Illuminate\Support\Collection;
use App\Repositories\Contracts\TransactionRepositoryInterface;

class TransactionByMember extends CacheBase
{
    use WithHelpers;

    protected int $memberId;

    public function __construct(int $memberId)
    {
        parent::__construct("transactions.by-member.{$memberId}", now()->addHour());

        $this->memberId = $memberId;
    }

    protected function cacheMiss(): Collection
    {
        return app(TransactionRepositoryInterface::class)
            ->filterByMember($this->memberId)
            ->get()
            ->map(fn ($transaction) => $transaction->only([
                'id', 'member_id', 'merchant_id', 'points', 'type', 'created_at'
            ]));
    }

    protected function errorModelName(): string
    {
        return "transactions";
    }

    protected function errorModelId()
    {
        return $this->memberId;
    }
}
