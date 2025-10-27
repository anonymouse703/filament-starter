<?php

namespace App\Enums\User;

use App\Enums\Traits\EnumToArray;

enum Role: string
{
    use EnumToArray;

    case SuperAdmin = 'super_admin';
    case Admin = 'admin';
}
