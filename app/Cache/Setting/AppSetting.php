<?php

namespace App\Cache\Setting;

use App\Cache\CacheBase;
use App\Enums\Setting\Scope as SettingScope;
use App\Models\Setting;
use App\Repositories\Contracts\SettingRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method Collection<Setting> fetch()
 */
class AppSetting extends CacheBase
{
    public function __construct()
    {
        parent::__construct("settings.app", now()->addHour());
    }

    protected function cacheMiss()
    {
        return app(SettingRepositoryInterface::class)
            ->filterByScopes(SettingScope::app())
            ->get();
    }

    protected function errorModelName(): string
    {
        return "Setting";
    }

    protected function errorModelId()
    {
        return 'settings';
    }
}
