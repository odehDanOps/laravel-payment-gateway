<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\BaseModel;

class Order extends BaseModel
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
    
    protected static function newFactory()
    {
        return \Modules\Order\Database\factories\OrderFactory::new();
    }
}
