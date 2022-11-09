<?php

namespace Modules\Payments\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Modules\Payments\Repositories\PaymentRepository;
use Modules\Order\Repositories\OrderRepository;
use Modules\Payments\Services\PaymentService;
class PaymentsController extends Controller
{
    /**
     * The payment service
     *
     * @var PaymentService
     */
    protected PaymentService $paymentService;

    /**
     * @var PaymentRepository
     * 
     */
    protected PaymentRepository $paymentRepository;

    /**
     * @var OrderRepository
     * 
     */
    protected OrderRepository $orderRepository;

    public function __construct(
        PaymentRepository $paymentRepository, 
        OrderRepository $orderRepository
    ){
        $this->paymentService = new PaymentService($paymentRepository, $orderRepository);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('payments::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('payments::create');
    }

    /**
     * Checkout Stripe Payment
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function checkoutStripePayment(Request $request)
    {
        $amount = $request->input('amount');
        $paymentOption = $request->input('payment_type');
        $redirectURL = null;
        try {
            $redirectURL = $this->paymentService->checkoutStripePayment($amount, $paymentOption);
        } catch (\Exception $e) {
            logger("Stripe Payment Error while completing payment :: TRACE :: " . $e->getTraceAsString());
            logger("Stripe Payment Error :: " . $e->getMessage());

            return response()->Json(['error' => false], 400);
        }

        try {
            if ($redirectURL !== null) {
                return response()->Json([
                    'success' => true,
                    'data' => $redirectURL
                ], 200);
            }
        } catch (\Exception $e) {
            logger("Stripe Payment Error while completing payment :: TRACE :: " . $e->getTraceAsString());
            logger("Stripe Payment Error while completing payment :: " . $e->getMessage());
        }
    }

    /**
     * Add Flutterwave Payment
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addFlutterwavePaymentOrder(Request $request)
    {
        $amount = $request->input('amount');
        $paymentOption = $request->input('payment_type');
        $order = null;

        if (Auth::guest() || Auth::user()) {
            try {
                $order = $this->paymentService->addPaymentOrder($amount, $paymentOption);
            } catch (\Exception $e) {
                logger("Flutterwave Payment Error while completing payment :: TRACE :: " . $e->getTraceAsString());
                logger("Flutterwave Payment Error :: " . $e->getMessage());
    
                return response()->Json(['error' => false], 400);
            }
    
            try {
                if ($order !== null) {
                    return response()->Json([
                        'success' => true,
                        'order' => $order
                    ], 200);
                }
            } catch (\Exception $e) {
                logger("Order Error while Flutterwave inserting records :: TRACE :: " .$e->getTraceAsString());
                logger("Order Error while Flutterwave inserting records :: " .$e->getMessage());
            }
        }
        return response()->Json([
            'success' => true,
            'order' => null
        ], 200);
    }

    /**
     * Checkout Flutterwave
     * @param Request $request
     *@return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function checkoutFlutterwavePayment(Request $request)
    {
        $orderId = $request->input('order');
        $amount = $request->input('amount');
        $paymentOption = $request->input('payment_type');
        $redirectURL = null;

        /** @var User $user */
        $user = Auth::user();
        if ($user || Auth::guest()) {
            try {
                $redirectURL = $this->paymentService->checkoutFlutterwavePayment($orderId, $amount, $paymentOption);
            } catch (\Exception $e) {
                Log::info("Flutterwave Checkout Error :: TRACE :: " . $e->getTraceAsString());
                Log::info("Flutterwave Checkout Error :: " . $e->getMessage());

                return response()->Json(['error' => false], 400);
            }

            try {
                if ($redirectURL !== null) {
                    return response()->Json([
                        'success' => true,
                        'data' => $redirectURL
                    ], 200);
                }
            } catch (\Exception $e) {
                Log::info("Checkout Error while completing payment :: TRACE :: " . $e->getTraceAsString());
                Log::info("Checkout Error while completing payment :: " . $e->getMessage());
            }
        }
        return response()->Json([
            'success' => true,
            'data' => '/welcome'
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
