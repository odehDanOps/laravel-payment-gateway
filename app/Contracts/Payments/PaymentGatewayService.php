<?php
 
namespace App\Payments;
 
interface PaymentGatewayService
{
	/**
     * Set secret key.
     *
     * @param  string  $secret
     * @return string
     */
    public function setSecretKey($secret);

	/**
     * Set public key.
     *
     * @param  string  $public_key
     * @return string
     */
    public function setPublicKey($public_key);

	/**
     * Set locale.
     *
     * @param  string  $locale
     * @return string
     */
    public function setLocale($locale);

	/**
     * Call payment gateway API
     *
     * @param  int  $_id
     * @param  int  $order_id
     * @param  float|int  $amount
     * @param  Array $meta
     *
     * @return array
     */
    public function callPaymentGateway($_id, $order_id, $amount, $meta);
}