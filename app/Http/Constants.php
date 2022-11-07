<?php
/**
 * User: daniel odeh
 * Date: 04/11/22
 * Time: 02:42 PM
 */

/**
 * Class UserType
 *
 * @package App\Http
 */
final class UserType
{
    const USER = '10';

    /**
     * Returns respective value.
     *
     * @param $x
     *
     * @return null
     */
    public static function getValue($x)
    {
        $value = null;
        switch ($x) {
            case '10':
                $value = __('User');
                break;
        }

        return $value;
    }

    /**
     * @return array
     */
    public static function getAll()
    {
        return [
            self::USER => UserType::getValue(self::USER)
        ];
    }
}

final class PaymentOption
{
    const STRIPE = '10';
    const FLUTTERWAVE = '20';

    /**
     * Returns respective value.
     *
     * @param $x
     *
     * @return null
     */
    public static function getValue($x)
    {
        $value = null;
        switch ($x) {
            case '10':
                $value = __('Stripe');
                break;
            case '20':
                $value = __('Flutterwave');
                break;
        }
        return $value;
    }

    /**
     * @return array
     */
    public static function getAll()
    {
        return [
            self::STRIPE => PaymentOption::getValue(self::STRIPE),
            self::FLUTTERWAVE => PaymentOption::getValue(self::FLUTTERWAVE)
        ];
    }
}

/**
 * Class OrderStatus
 */
final class OrderStatus
{
    CONST NEW = '10';
    CONST PAYMENT_PENDING = '20';
    CONST PAYMENT_FAILED = '30';
    CONST SUCCESS = '40';
}