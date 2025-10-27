<?php

namespace App\Cache\Merchant;

use App\Cache\CacheBase;
use App\Cache\WithHelpers;
use App\Repositories\Contracts\MerchantRepositoryInterface;
use Illuminate\Support\Arr;

/**
 * @method \Illuminate\Support\Collection fetch()
 */

class Merchant extends CacheBase
{
    use WithHelpers;

    public function __construct()
    {
        parent::__construct("merchants", now()->addHour());
    }

    protected function cacheMiss()
    {
        return app(MerchantRepositoryInterface::class)->with(['merchantLogo'])
                ->filterByActive()
                ->get();
    }

    protected function errorModelName(): string
    {
        return "Merchant";
    }

    protected function errorModelId()
    {
        return null;
    }
}
