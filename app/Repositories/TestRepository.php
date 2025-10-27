<?php

namespace App\Repositories;

use App\Models\Test;
use App\Repositories\Contracts\TestRepositoryInterface;

class TestRepository extends BaseRepository implements TestRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(app(Test::class));
    }
}
