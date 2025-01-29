<?php

namespace App\Utils;

use Illuminate\Database\Eloquent\Builder;

trait ModelHelperTrait
{
    public function scopeCustomPaginate(Builder $query, $perPage = 10)
    {
        return $query->paginate($perPage);
    }
}
