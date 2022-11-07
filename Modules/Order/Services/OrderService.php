<?php

namespace Modules\Order\Services;

use Modules\Order\Repositories\OrderRepository;
use Modules\Order\Entities\Order;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * The payments repository
     *
     * @var OrderRepository
     */
    protected OrderRepository $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param int $amount
     * @param string $paymentOption
     * @return mixed
     */
    public function addStripePayment($amount, $paymentOption)
    {
        $order = $this->orderRepository->addOrder($amount, $paymentOption);
        return $task;
    }

}
