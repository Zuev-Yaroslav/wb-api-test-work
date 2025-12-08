<?php

namespace App\Models\Traits;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @mixin Builder
 */

trait HasGetFreshData
{
    public static function scopeFreshFilter(Builder $builder) : Builder
    {
        $now = Carbon::now()->format('Y-m-d');
        $modelTodayExists = static::where('date', '>=', $now)->exists();
        if (!$modelTodayExists) {
            $model = static::orderBy('date', 'desc')->first();
            $lastDate = (new Carbon($model->date))->format('Y-m-d');
            $builder->where('date', '>=', $lastDate);
        } else {
            $builder->where('date', '>=', $now);
        }
        $builder->orderBy('date', 'desc');
        return $builder;
    }
    public function scopeLatestDate(Builder $builder) : Builder
    {
        return $builder->orderBy('date', 'desc');
    }
}
