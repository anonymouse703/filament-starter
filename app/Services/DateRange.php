<?php

namespace App\Services;

use App\Enums\RangeStringFilter;
use App\Exceptions\InvalidDateRangeType;
use Carbon\Carbon;

class DateRange
{
    protected static function getStartAndEndOfDay(Carbon $start, Carbon $end): array
    {
        return [$start->startOfDay(), $end->endOfDay()];
    }

    protected static function getCurrentDate(string $timezone = null): Carbon
    {
        return now($timezone ?? config('app.timezone'));
    }

    public static function today(string $timezone = null): array
    {
        $currentDate = self::getCurrentDate($timezone);

        return self::getStartAndEndOfDay($currentDate, clone $currentDate);
    }

    public static function yesterday(string $timezone = null): array
    {
        $currentDate = self::getCurrentDate($timezone);
        $yesterday = (clone $currentDate)->subDay();

        return self::getStartAndEndOfDay($yesterday, clone $yesterday);
    }

    public static function currentMonth(string $timezone = null, bool $includeToday = false): array
    {
        $currentDate = self::getCurrentDate($timezone);
        $startOfMonth = (clone $currentDate)->startOfMonth();
        $endOfRange = $includeToday ? $currentDate : (clone $currentDate)->subDay();

        return self::getStartAndEndOfDay($startOfMonth, $endOfRange);
    }

    public static function lastMonth(string $timezone = null): array
    {
        $currentDate = self::getCurrentDate($timezone);
        $startOfLastMonth = (clone $currentDate)->subMonthNoOverflow()->startOfMonth();
        $endOfLastMonth = (clone $startOfLastMonth)->endOfMonth();

        return self::getStartAndEndOfDay($startOfLastMonth, $endOfLastMonth);
    }

    /**
     * @throws InvalidDateRangeType
     */
    public static function getRange(string $type, string $timezone = null): array
    {
        return match ($type) {
            RangeStringFilter::Today->value => self::today($timezone),
            RangeStringFilter::Yesterday->value => self::yesterday($timezone),
            RangeStringFilter::CurrentMonth->value => self::currentMonth($timezone),
            RangeStringFilter::LastMonth->value => self::lastMonth($timezone),
            default => throw new InvalidDateRangeType('Type not supported')
        };
    }
}
