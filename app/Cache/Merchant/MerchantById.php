<?php

namespace App\Cache\Merchant;

use App\Cache\CacheBase;
use App\Cache\WithHelpers;
use App\Models\Merchant as Model;
use App\Repositories\Contracts\MerchantRepositoryInterface;

/**
 * @method Model|null fetch()
 * @method Model fetchOrFail()
 */
class MerchantById extends CacheBase
{
    use WithHelpers;

    public function __construct(protected int $id)
    {
        parent::__construct("merchants.{$id}", now()->addHour());
    }

    protected function cacheMiss()
    {
        // return app(MerchantRepositoryInterface::class)->find($this->id);
        return app(MerchantRepositoryInterface::class)->with(['merchantLogo'])->find($this->id);
    }

    protected function errorModelName(): string
    {
        return "merchant";
    }

    protected function errorModelId()
    {
        return $this->id;
    }
}
