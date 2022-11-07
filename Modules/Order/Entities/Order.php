<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'amount',
        'currency',
        'payment_option',
    ];

    /**
     * Default Currency for Order.
     */
    const DEFAULT_CURRENCY = "NGN";

    /**
     * returns Order By Id.
     *
     * @param $id
     *
     * @return mixed
     */
    public static function get($id)
    {
        return Order::find($id);
    }
    
    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\OrderFactory::new();
    }
}