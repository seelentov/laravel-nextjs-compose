<?php


namespace App\Http\Filters\Interfaces;


use Illuminate\Database\Eloquent\Builder;

interface IFilter
{
    public function apply(Builder $builder);
}
