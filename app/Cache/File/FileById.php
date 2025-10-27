<?php

namespace App\Cache\File;

use App\Cache\CacheBase;
use App\Models\File;
use App\Repositories\Contracts\FileRepositoryInterface;

/**
 * @method File|null fetch()
 * @method File fetchOrFail()
 */
class FileById extends CacheBase
{
    public function __construct(protected int $id)
    {
        parent::__construct("files.{$id}", now()->addHour());
    }

    protected function cacheMiss()
    {
        return app(FileRepositoryInterface::class)->find($this->id);
    }

    protected function errorModelName(): string
    {
        return "File";
    }

    protected function errorModelId()
    {
        return $this->id;
    }
}
