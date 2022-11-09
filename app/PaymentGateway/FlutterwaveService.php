<?php
 
namespace App\PaymentGateway;

use App\PaymentGateway\Helpers\PaymentProvider;
use App\Contracts\Payments\PaymentGatewayService as Service;

use Modules\Order\Entities\Order;
 
class FlutterwaveService implements Service
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
    public function setPublicKey($_public_key){
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
	 * Set Encryption key.
	*
	* @param  string  $_encryption_key
	* @return string
	*/
	public function setEncryptionKey($_encryption_key){
		$encryption_key = config($_encryption_key);
		return  $encryption_key;
	}


	/** 
	* Set SecretHash key.
	*
	* @param  string  $_secret_hash_key
	* @return string
	*/
	public function setSecretHashKey($_secret_hash_key){
		$secret_hash_key = config($_secret_hash_key);
		return  $secret_hash_key;
	}

	/** 
	 * Set keys.
	*
	* @return Array []
	*/
	public function setKeys(){
		$set_public_key = 'services.flutterwave.public_key';
		$set_secret_key = 'services.flutterwave.secret_key';
		$set_encryption_key = 'services.flutterwave.encryption_key';
		$set_secret_hash_key = 'services.flutterwave.secret_hash';
		$set_locale = 'services.flutterwave.locale';

		$flutterwave_public_key = $this->setPublicKey($set_public_key);
		$flutterwave_secret_key =  $this->setSecretKey($set_secret_key);
		$flutterwave_encryption_key =  $this->setEncryptionKey($set_encryption_key);
		$flutterwave_secret_hash_key =  $this->setSecretHashKey($set_secret_hash_key);
		$flutterwave_locale_key =  $this->setLocale($set_locale);

		$keys = [
			"public_key" => $flutterwave_public_key,
			"secret_key" => $flutterwave_secret_key,
			"secret_hash_key" => $flutterwave_secret_hash_key,
			"encryption_key" => $flutterwave_encryption_key,
			"locale" => $flutterwave_locale_key,
		];
		return $keys;
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
		$key = $this->setKeys();
		$payments_url = "https://api.flutterwave.com/v3/payments";
		$redirect_url = url("/order/process-payment");
		$request = [];
		$request["tx_ref"] = $order_id;
		$request["amount"] = $amount;
		$request["currency"] = Order::DEFAULT_CURRENCY;
		$request["redirect_url"] = $redirect_url;
		$request["payment_options"] = "card";

		$request["customer"] = [
			"email" => "hi@danops.dev",
			"name" => $meta['first_name']. " " .$meta['last_name'],
		];

		$request["customizations"] = [
		"title" => "Multiple Payment Integration",
		"description" => "Pay now.",
		"logo" => "https://flutterwave.com/images/logo/full.svg"
		];

		$response = PaymentProvider::curlAPI("POST", $payments_url, $request, $key);
		return $response;
	}
}