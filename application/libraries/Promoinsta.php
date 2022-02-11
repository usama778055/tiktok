<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Promoinsta
{
	private $_CI;
	public function __construct()
	{
		$this->_CI = &get_instance();
		$this->_CI->load->library('form_validation');
		$this->_CI->load->helper('file');
	}

	public function findPromo()
	{
		$promo = $this->_CI->input->post('promo', true);
		if ($this->_CI->session->userdata('cart') == FALSE) {
			return json_encode(array('success' => 0, 'data' => 'Please add product to  cart first.'));
		}
		//$profileData = $this->_CI->session->userdata('profile_data');
		//echo "<pre>";print_r($profileData);exit;
		//$profile_id = $profileData['profile_id'];
		$pkg_price = $_SESSION['cart']["total_amount"];

		$results = $this->_CI->Mob_admin->checkPromo($profile_id='', $promo);
		if ($results['success'] == 1) {
			$promoRes = $results['data'];
			$_SESSION['discount'] = array();
			$return = $this->setPromoData($promo, $pkg_price, $promoRes);
		} else {
			$return = array('success' => 0, 'data' => 'Promo not found.');
		}
		$result = json_encode($return);
		return $result;
	}

	function setPromoData($promo, $amount, $promoData)
	{
		$valid = $this->checkIfValid($promoData);
		if ($valid['success'] == 0) {
			return $valid;
		}

		$discountPercent        = $promoData['discountPercent'];   // Discount in percentage
		$discountPrice          = $amount * $discountPercent / 100;   // Discount in amount
		$offPrice = round($discountPrice, 2);
		$discount_pkgprice      = $amount - $offPrice;           // Amount after discount
		$discountedPrice = round($discount_pkgprice, 2);

		$data = array(
			'discount_pkgprice' => $discountedPrice,
			'discountPercent' => $discountPercent,
			'discountPrice' => $offPrice
		);
		$this->discountedSession($promo, $amount, $data);
		$result = array('success' => 1, 'data' => $data);
		return $result;
	}

	private function discountedSession($promo, $amount, $data)
	{
		// print_r($_SESSION['package_detail']);exit();
		$_SESSION['discount'] = array(
			'discount_percent'  => $data['discountPercent'],
			'orignal_price'     => $amount,
			'discount_price'    => $data['discountPrice'],
			'promoCode'         => $promo,
			'discount_pkgprice' => $data['discount_pkgprice']
		);
		$discount_pkgprice = $data['discount_pkgprice'];
		$_SESSION['package_detail']->discountPrice = $discount_pkgprice;
	}

	private function checkIfValid($data)
	{
		// print_r($data);
		$result = array('success' => 1);
		$condition1 = ($data['promo_limit'] >= 0); // Limit condition
		$condition2 = ($data['end_date'] > date("Y-m-d")); // Expiry condition

		if (!$condition1 || !$condition2) {
			$error_message = "The Promo code is invalid or expired. Please contact support.";
			$result['success'] = 0;
			$result['message'] = $error_message;
			// $result['data'] = json_encode($data);
			// $result['condition1'] = $condition1;
			// $result['condition2'] = $condition2;
		}
		return $result;
	}

	function checkPromoError($promoRes = array())
	{

		$promo_limit  = $this->promoLimit($promoRes['promo_limit'], $promoRes['promo_used']);
		$promo_date   = $this->promodate($promoRes['end_date']);
		$res = array('error' => 0);

		$error_message = (empty($promoRes)) ? 'Invalid promo code. Contact to support to get a promo.' : (($promo_limit == 0) ? 'Promo limit exceeded !' : (($promo_date == 0) ? 'Promo has been expired. !' : ''));
		//                       (($promoRes['user'] > 0)?'Promo already used !':'')    // disabled for now.

		if ($error_message != '') {
			$res['error'] = 1;
			$res['message'] = $error_message;
		}
		return $res;
	}
}
