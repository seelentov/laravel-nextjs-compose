<?php


// namespace App\Http\Filters;

// use App\Http\Filters\Abstract\AbstractFilter;
// use Illuminate\Database\Eloquent\Builder;

// class PositionFilter extends AbstractFilter
// {
//     public const CURRENCY_ID = 'currency_id';
//     public const EXCHANGE_ID = 'exchange_id';


//     protected function getCallbacks(): array
//     {
//         return [
//             self::CURRENCY_ID => [$this, 'currency_id'],
//             self::EXCHANGE_ID => [$this, 'exchange_id'],
//         ];
//     }



//     public function exchange_id(Builder $builder, $value)
//     {
//         $builder->where('exchange_id', $value);
//     }

//     public function currency_id(Builder $builder, $value)
//     {
//         $builder->where('currency_id', $value);
//     }
// }
