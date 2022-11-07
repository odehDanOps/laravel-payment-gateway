<?php
namespace Modules\Order\Repositories;

use Modules\Order\Entities\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderRepository
{
    /**
     * returns Order By Id.
     *
     * @param $id
     *
     * @return mixed
     */
    public function get($id)
    {
        return Order::find($id);
    }

    /**
     * @param int $amount
     * @param string $paymentOption
     * @return Order
     */
    public function addOrder($amount, $paymentOption)
    {
        $order = Order::create([
            'email' => "johndoe@example.com",
            "amount" => $amount,
            "currency" => "usd",
            "payment_option" => $paymentOption
        ]);
        return $order;
    }
    
}
