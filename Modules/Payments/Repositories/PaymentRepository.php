<?php
namespace Modules\Payments\Repositories;

use Modules\Payments\Entities\Payments;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentRepository
{
    /**
     * @param int $paymentId
     * @return Payments
     */
    public function getPaymentById(int $paymentId): User
    {
        return Payments::find($userId);
    }
    
}
