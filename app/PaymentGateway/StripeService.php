<?php
 
namespace App\PaymentGateway;

use App\PaymentGateway\Helpers\PaymentProvider;
use App\Payments\PaymentGatewayService as Service;
use Stripe\Stripe;
 
class StripeService extends Service
{
    /**
     * Set secret key.
     *
     * @param  string  $secret
     * @return string
     */
    public function setSecretKey($secret){
		$secret_key = config($secret);
    	return  $secret_key;
	}

	/**
     * Set public key.
     *
     * @param  string  $public_key
     * @return string
     */
    public function setPublicKey($public_key){
		$public_key = config($_public_key);
    	return  $public_key;
	}

	/**
     * Set locale.
     *
     * @param  string  $locale
     * @return string
     */
    public function setLocale($locale){
		$locale = config($locale);
      	return  $locale;
	}


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
    public function callPaymentGateway($_id, $order_id, $amount, $meta){
		$success_url = url("/order/process-stripe-payment/?id={$_id}&orderId={$order_id}");
		$cancel_url = url("/order/process-stripe-payment/?orderId={$order_id}");

		$set_locale = 'services.stripe.locale';
		$set_secret_key = 'services.stripe.secret';

		$stripeLocale = $this->setLocale($set_locale);
		$stripe_secret_key =  $this->setSecretKey($set_secret_key);

		Stripe::setApiKey($stripe_secret_key);
		$session = \Stripe\Checkout\Session::create([
			'payment_method_types' => ['card'],
			'line_items' => [[
				'price_data' => [
				'currency' => $stripeLocale,
				'unit_amount' => $amount*100,
				'product_data' => [
					'name' => $meta['name'],
					'images' => ["https://images.ctfassets.net/fzn2n1nzq965/2EOOpI2mMZgHYBlbO44zWV/5a6c5d37402652c80567ec942c733a43/favicon.png?w=180&h=180"],
				],
				],
				'quantity' => 1,
			]],
			'mode' => 'payment',
			'success_url' => $success_url,
			'cancel_url' => $cancel_url,
			"metadata" => [
				"order_id" => $order_id
			],
		]);
		return $session;
	}
}