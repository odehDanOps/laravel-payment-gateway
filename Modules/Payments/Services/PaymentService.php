<?php

namespace Modules\Payments\Services;

use Modules\Payments\Repositories\PaymentRepository;
use Modules\Order\Repositories\OrderRepository;
use Modules\Payments\Entities\Payments;
use App\PaymentGateway\StripeService;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * The payments repository
     *
     * @var PaymentRepository
     */
    protected PaymentRepository $paymentRepository;

    /**
     * The order repository
     *
     * @var OrderRepository
     */
    protected OrderRepository $orderRepository;

    public function __construct(
        PaymentRepository $paymentRepository,
        OrderRepository $orderRepository
    )
    {
        $this->paymentRepository = $paymentRepository;
        $this->orderRepository = $orderRepository;
    }

    /**
     * @param int $amount
     * @param string $paymentOption
     * @return mixed
     */
    public function addStripePayment($amount, $paymentOption)
    {
        $orderRepo = $this->orderRepository->addOrder($amount, $paymentOption);
        if ($orderRepo) {
            try {
                $orderId = $orderRepo->id;
                $meta = [
                    "name" => "DevOps"
                ];
                $stripeService = new StripeService();
                $session = $stripeService->callPaymentGateway($userId=1, $orderId, $amount, $meta);

                $order = $this->orderRepository->get($orderId); 
                $order->ref_transaction_id = $session->payment_intent;
                $order->ref_order_id = $session->payment_intent;
                $order->ref_id = $session->id;
                $order->status = \OrderStatus::PAYMENT_PENDING;
                $order->save();
                logger("Payment Before calling Stripe API :: ");

                return $session;
            } catch(\Stripe\Exception\CardException $e) {
                logger("API call failed Status is:  " . htmlspecialchars($e->getHttpStatus()));
                logger("API call failed Type is: " . htmlspecialchars($e->getError()->type));
                logger("API call failed Code is: " . htmlspecialchars($e->getError()->code));
                logger("API call failed Param is: " . htmlspecialchars($e->getError()->param));
                logger("API call failed Message is: " . htmlspecialchars($e->getError()->message));
            }
            return $task;
        }
    }

}
