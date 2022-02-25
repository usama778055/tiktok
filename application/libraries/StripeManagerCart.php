<?php
defined("BASEPATH") or exit("No direct access allow");

class StripeManagerCart
{
	private $_CI;
	public function __construct()
	{
		$this->_CI = &get_instance();
		$this->post = $this->_CI->postData;
		$this->_CI->load->model('Users');

		$this->currency = 'gbp';
	}

	public function setStripeSession()
	{

		$cart =  $_SESSION['cart'];
		//$pckg = $_SESSION['package_detail'];
		//$price = (isset($pckg['discountPrice'])) ? $pckg['discountPrice'] : $pckg['packagePrice'];
		$price = $cart['total_amount'];
		if (isset($_SESSION['discount'])) {
			$price = $_SESSION['discount']['discount_pkgprice'];
		}
		$_SESSION['price_paid'] = $price;

		require_once(__DIR__ . '/../third_party/stripe-php/init.php');
		$stripeSetting = $this->get_stripe_setting();

		$this->writefile(json_encode($stripeSetting), 'stripeSettings');

		\Stripe\Stripe::setApiKey($stripeSetting->stripeSecretKey);
		$response = array(
			'status' => 0,
			'error' => array('message' => 'Invalid Request!')
		);
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$request = $this->_CI->input->post();
			$request = (object) $request;
		}

		if (json_last_error() !== JSON_ERROR_NONE) {
			http_response_code(400);
			exit(json_encode($response));
		}
		if (!empty($request->checkoutSession)) {
			if (!empty($_SESSION['customer_id'])) {
				$stripe = new \Stripe\StripeClient(
					$stripeSetting->stripeSecretKey
				);
				try {
					$client = $stripe->customers->retrieve(
						$_SESSION['customer_id'],
						[]
					);
					if (isset($client->deleted)) {
						$customer = array('' => '');
					} else {
						$customer = array('customer' => $_SESSION['customer_id']);
					}
				} catch (\Stripe\Exception\InvalidRequestException $e) {
					$customer = array('' => '');
					// Invalid parameters were supplied to Stripe's API
				} catch (\Stripe\Exception\ApiErrorException $e) {
					$customer = array('' => '');
					// Display a very generic error to the user, and maybe send
					// yourself an email
				} catch (Exception $e) {
					$customer = array('' => '');
					// Something else happened, completely unrelated to Stripe
				}
			} else {
				$customer = array('' => '');
			}
			// Create new Checkout Session for the order
			try {
				// $currency = array_search($_SESSION['country'], $this->currency);
				$currency =  $this->currency;
				$new_order = isset($_SESSION['new_order']) ? $_SESSION['new_order'] : '';
				$sessionArray = [
					$customer,
					"payment_method_types" => ['card'],
					"metadata" => [
						"pro_id" => 0,
						"new_order" => $new_order
					],
					"line_items" => [[
						"price_data" => [
							"product_data" => [
								"name" => "Total"
							],
							"unit_amount" => $price * 100,
							"currency" =>  $currency,

						],
						"quantity" => 1,
						"description" => "Total",


					]],
					"mode" => "payment",
					"success_url" => base_url() . 'cart/stripeSuccess?session_id={CHECKOUT_SESSION_ID}',
					"cancel_url" => base_url() . 'order-cancel',
				];
				$this->writefile(json_encode($sessionArray), 'stripeSettings');
				$session = \Stripe\Checkout\Session::create($sessionArray);
			} catch (Exception $e) {
				$api_error = $e->getMessage();
			}

			if (empty($api_error) && $session) {
				$response = array(
					'status' => 1,
					'message' => 'Checkout Session created successfully!',
					'sessionId' => $session['id'],
				);
			} else {
				$response = array(
					'status' => 0,
					'error' => array(
						'message' => 'Checkout Session creation failed! ' . $api_error
					)
				);
			}
		}
		return $response;
	}
	public function prepareStripeDataAfterSuccess($sucessResult)
	{
		$meta = array(
			'created' => $sucessResult['transaction_date'],
			'last4' => $sucessResult['last4'],
			'receipt_url' => $sucessResult['receipt_url']
		);

		$data = array(

			'stripe_transaction_id' => $sucessResult['stripe_txn_id'],
			'payment_status' => $sucessResult['paymentStatus'],
			'stripe_payment_method' => $sucessResult['stripe_payment_method'],
			'charge_id' => $sucessResult['charge_id'],
			'intentID' => $sucessResult['intentID'],
			'name' => $sucessResult['name'],
			'customer_id' => $sucessResult['customer_id'],
			'email' => $sucessResult['email'],
			'gateway' => 'stripe',

			'stripe_meta' => json_encode($meta)

		);

		$_SESSION['price_paid'] = $sucessResult['paidAmount'];

		return $data;
	}

	public function insertStripeTransactionDetail($sucessResult)
	{
		$orderId = $_SESSION['new_order'];
		$stripe_order_data = array(
			'order_id' => $orderId,
			'user_email' => $sucessResult['email'],
			'charge_id' => $sucessResult['charge_id'],
			'stripe_txn_id' => $sucessResult['stripe_txn_id'],
			'transaction_date' => $sucessResult['transaction_date'],
			'stripe_status' => $sucessResult['paymentStatus'],
			'stripe_username' => $sucessResult['name'],
			'customer_id' => $sucessResult['customer_id'],
			'receipt_url' => $sucessResult['receipt_url'],
			'intentID' => $sucessResult['intentID'],
			'paid_amount' => $sucessResult['paidAmount'],
			'stripe_payment_method' => $sucessResult['stripe_payment_method']
		);
		$this->_CI->Users->insertStripeData($stripe_order_data);
	}

	public function get_stripe_setting()
	{
		$stripeSettings = array();
		if (isset($_SESSION['user_email']) && $_SESSION['user_email'] == 'nelsonmtaylor336@gmail.com') {
			$stripeSettingStr = '{"id":"1",
            "companyName":"tiktok markting",
            "currency":"gbp",
            "stripePublishableKey":"pk_test_8J9m8cSUoJ6EBJm14lYVMbMa",
            "stripeSecretKey":"sk_test_nFN6e7rfDdw4OmVLtabpIhI3",
            "sandbox":"0"}';
			$stripeSettings = json_decode($stripeSettingStr);
		} else {
			$stripeSetting = $this->_CI->Users->get_stripe_data();
			if ($stripeSetting['success'] == 1) {
				$stripeSettings = $stripeSetting['data'];
			}
		}
		$this->writefile(json_encode($stripeSettings), 'stripeSettings1');
		return $stripeSettings;
	}

	public function writefile($string, $heading)
	{
		$logsPath = FCPATH . 'application/views/logs/' . date("Y-m-d") . '/';
		//echo  $logsPath;exit;
		if (!file_exists($logsPath)) {
			mkdir($logsPath, 0777, true);
		}
		@write_file($logsPath . 'logs.php', '<h2>' . $heading . '</h2><p> ' . $string . "</p> \r\n", 'a');
	}
}
