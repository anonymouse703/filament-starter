<?php

namespace App\Enums;

use App\Enums\Traits\EnumToArray;

enum RangeStringFilter: string
{
    use EnumToArray;

    case LastMonth = 'last_month';
    case Yesterday = 'yesterday';
    case Today = 'today';
    case CurrentMonth = 'current_month';
}
