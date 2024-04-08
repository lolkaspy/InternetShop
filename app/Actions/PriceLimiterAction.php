<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Builder;

class PriceLimiterAction
{
    public static function getMinLimit(Builder $query, string $column): float
    {
        $minQuery = clone $query;

        return round($minQuery->min($column));
    }

    public static function getMaxLimit(Builder $query, string $column): float
    {
        $maxQuery = clone $query;

        return round($maxQuery->max($column));
    }
}
