<?php

namespace Modules\Payments\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function addStripePayment(Request $request)
    {
        $amount = $request->input('amount');
        $paymentOption = $request->input('payment_type');
        $redirectURL = null;
        try {
            $redirectURL = $this->paymentService->addStripePayment($amount, $paymentOption);
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
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('payments::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('payments::edit');
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
