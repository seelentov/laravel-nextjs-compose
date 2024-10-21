<?php


namespace App\Models\Traits;


use App\Http\Filters\Interfaces\IFilter;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * @param Builder $builder
     * @param IFilter $filter
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, IFilter $filter)
    {
        $filter->apply($builder);
        return $builder;
    }
}
