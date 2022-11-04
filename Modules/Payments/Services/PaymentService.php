<?php

namespace Modules\Payments\Services;

use Modules\Payments\Repositories\PaymentRepository;
use Modules\Payments\Entities\Payments;
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

    public function __construct(PaymentRepository $paymentRepository)
    {
        $this->paymentRepository = $paymentRepository;
    }
}
