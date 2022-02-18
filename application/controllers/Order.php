<?php
class Order extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->currency = 'gbp';
		$this->load->helper('template');
		$this->load->model('genral_model');
		$this->clear_cache();
	}

	public function clear_cache()
	{
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header("Expires: Mon, 26 Jul 1985 05:00:00 GMT");
	}

	private function getTypeAndLimit($category, $service_type = '')
	{
		$all_categories = array(
			'tiktok' => array(
				'comments' => 3,
				'likes' => 100,
				'livestream' => 250,
				'views' => 250,
			),
		);
		$typeLimit = ($all_categories[$category][$service_type]) ?? 50;
		return $typeLimit;
	}
	// no need to select posts on App page
	public function is_auto_service($category, $service_type = '')
	{
		$all_categories = array(
			'tiktok' => array(
				'autolikes',
				'followers',
				'autoviews',
				'livestream',
			),

		);
		return in_array($service_type, $all_categories[$category]);
	}

	public function pkg_page($category_slug, $service_type)
	{

		$category = $this->genral_model->getByColumnArray('categories', 'name', $category_slug);
		if (!isset($category) || empty($category)) {
			return $this->load->view('404');
		}
		$category = $category[0];
		$data['packages_sub_cat'] = $this->get_packages_for_subCategory($category, $service_type);
		$sub_cat_data = $this->genral_model->get_description($category['id'], $service_type);
		$data['descriptions'] = $sub_cat_data;

		if (empty($data['packages_sub_cat']))
			return $this->load->view('404');

		$data['category'] = $category;
		$data['service_type'] = $service_type;
		$data['packageTitle'] = $data['packages_sub_cat'][0]['packageTitle'];

		$data["title"] = ($sub_cat_data['page_title'] != '') ? $sub_cat_data['page_title'] : "Buy " . $category_slug . " " . $service_type;
		$data['meta_description'] = ($sub_cat_data['meta_description'] != '') ? $sub_cat_data['meta_description'] : 'Buy Instagram Followers UK and boost your profile. Instagram Likes UK & Views enhance engagement. 100% Real & Secured with PayPal.';
		$data['canonical'] = (isset($sub_cat_data['canonical']) && $sub_cat_data['canonical'] != '') ? $sub_cat_data['canonical'] : '';

		// Remove/comment below two lines
		$data["title"] = "Buy " . $category_slug . " " . $service_type;
		$data['meta_description'] = 'Buy Instagram Followers UK and boost your profile. Instagram Likes UK & Views enhance engagement. 100% Real & Secured with PayPal.';
		$this->load->view('categorized_pkgs', $data);
	}

	public function app_page($qty, $cate_slug, $serviceType)
	{
		$this->load->helper('template');
		if (isset($_GET['test'])) {
			echo '<pre>';
			print_r($this->session->userdata());
			exit;
		}

		$this->load->model('genral_model');
		$category = $this->genral_model->getByColumnArray('categories', 'name', $cate_slug);
		if (!isset($category) || empty($category)) {
			return $this->load->view('404');
		}
		$category = $category[0];
		$packages = $this->get_packages_for_subCategory($category, $serviceType);
		$pckg = $this->get_product_detail($qty, $category, $serviceType);
		$best_combos = $this->genral_model->getColsLimitWhere('igservices', 'packageQty, priceUnit, packagePrice, packageTitle, serviceType', 'favourite = 1', 6);

		if (empty($pckg)) {
			return $this->load->view('404');
		}


		$data = $this->prepare_view_data($pckg, $category);
		$data['category'] = $category;
		$data['packages'] = $packages;
		$data['best_combos'] = $best_combos;
		$data['meta_description'] = isset($pckg->meta_description) ? $pckg->meta_description : 'Buy Instagram Followers UK and boost your profile. Instagram Likes UK & Views enhance engagement. 100% Real & Secured with PayPal.';
		$data['canonical'] = (isset($pckg->canonical) && $pckg->canonical != '') ? $pckg->canonical : '';
		$this->session->set_userdata('package_detail', $pckg);
		$orderId = time() . $pckg->service_id;
		$this->session->set_userdata('new_order', $orderId);
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$data['csrf'] = $csrf;
		if ($cate_slug == "instagram") {
			$this->load->view('app_page', $data);
		} else {
			add_js('app_other.js');
			$this->load->view('app_other_page', $data);
		}
	}

	/**
	 *  Order success page.
	 */
	public function successInvoice($order_id = '')
	{

		$orderDetail = (isset($_SESSION['order_detail']) && is_array($_SESSION['order_detail']) &&
			!empty($_SESSION['order_detail'])) ? $_SESSION['order_detail'] : array();
		$this->session->unset_userdata('order_detail');
		if (empty($orderDetail)) {
			header('location: ' . base_url('tracking/' . $order_id));
		} else {
			$emailData = $this->prepareEmailData($orderDetail);
			$this->load->library('mobemail');
			$this->mobemail->mobSuccesOrderMail($emailData);
			$this->load->view('Success_invoice', $emailData);
		}
	}

	public function multiOrderSuccessInvoice($order_id = '')
	{
		//echo  "<pre>";print_r($this->session->all_userdata());exit;
		$orderItemDetail = (isset($_SESSION['order_items']) && is_array($_SESSION['order_items']) &&
			!empty($_SESSION['order_items'])) ? $_SESSION['order_items'] : array();
		if (empty($orderItemDetail)) {
			header('location: ' . base_url('tracking/' . $order_id));
		} else {
			$emailData = $this->prepareMultiEmailData();
			//echo "<pre>";print_r($emailData);exit;
			$cartData = (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) ? $_SESSION['cart'] : array();
			$discount = isset($_SESSION['discount']) ? $_SESSION['discount'] : array();
			$data = array('cartData' => $cartData, 'discount' => $discount, 'emailData' => $emailData);
			//$this->load->library('mobemail');
			//$this->mobemail->mobMultiSuccesOrderMail($data);
			$this->unsetSession();
			$this->load->view('order-success', $data);
		}
	}

	private function prepareMultiEmailData()
	{
		// $currency = array_search($_SESSION['country'], $this->currency);
		$currency = $this->currency;
		$emailData = array(
			'orderId' => $_SESSION['new_order'],
			'user_email' => $_SESSION['user_email'],
			'currency' =>  $currency,
			'selected_posts' => isset($_SESSION['selected_posts']) ? $_SESSION['selected_posts'] : false,
			'price_paid' => $_SESSION['price_paid'] ?? false,
			'trackOrderLink' => base_url() . 'tracking/' . $_SESSION['new_order'],
			// 'discount' => $_SESSION['discount'],
		);
		return $emailData;
	}

	private function prepareEmailData($orderDetail)
	{
		$pkg = isset($orderDetail['package_detail']) ? json_decode($orderDetail['package_detail'], true) : $_SESSION['package_detail'];
		$selected_posts = isset($_SESSION['selected_posts']) ? $_SESSION['selected_posts'] : '';
		$pckgQuty = ($pkg['displayQty'] != '') ? $pkg['displayQty'] != '' : $pkg['packageQty'];
		$discount = $this->session->userdata('discount');
		$emailData = array(
			'orderId'       => $_SESSION['new_order'],
			'user_email'    => $_SESSION['user_email'],
			'user_image'    => $_SESSION['profile_data']['profileImage'],
			'imagedata'     => isset($_SESSION['requestData']) ? $_SESSION['requestData'] : array(),
			'profile_link'  => IG_URL . $_SESSION['user_name'],
			'posts_data'    => $selected_posts,
			'quantity'      => $pckgQuty,
			'sType'         => $pckgQuty . ' IG ' . ucfirst($pkg['serviceType']),
			'serviceType'   => $pkg['serviceType'],
			'serType'       => $pkg['packageTitle'],
			'currency'      => 'GBP',
			'trackOrderLink' => base_url() . 'track-order/' . $_SESSION['new_order'],
			'user_name'     => isset($_SESSION['profile_data']['full_name']) ?
				$_SESSION['profile_data']['full_name'] : $_SESSION['user_name'],
		);
		$emailData = $this->getPriceInfo($pkg, $emailData);
		return $emailData;
	}

	public function getPriceInfo($pkg, $data)
	{
		$discount = ($this->session->userdata('discount') != FALSE) ? $this->session->userdata('discount') : array();
		$data['price'] = isset($pkg['discountPrice']) ? $pkg['discountPrice'] : $pkg['packagePrice'];
		$data['orignalprice'] = isset($discount['orignal_price']) ? $discount['orignal_price'] : 00;
		$data['dscpercent'] = isset($discount['discount_percent']) ? $discount['discount_percent'] : 00;
		$data['dscprice'] = isset($discount['discount_price']) ? $discount['discount_price'] : 00;

		return $data;
	}

	/* Track order */
	public function trackOrder($orderId = '')
	{
		if ($this->input->post('action', True) != false) {
			$this->load->library('reqservice');
			$orderId = $this->input->post('order_id');
			$result = $this->reqservice->trackMultiOrder($orderId);
			// $result = $this->reqservice->trackOrder($orderId);
			exit(json_encode($result));
		}
		$this->load->view('track_order', array('order_id' => $orderId));
	}
	/* Track Old orders */
	public function trackOldOrder($orderId = '')
	{
		add_css('tracking.css');
		add_js('tracking.js');
		if ($this->input->post('action', True) != false) {
			$this->load->library('reqservice');
			$orderId = $this->input->post('order_id');
			$result = $this->reqservice->trackOrder($orderId);
			exit(json_encode($result));
		}
		$this->load->view('track_order', array('order_id' => $orderId));
	}

	/**
	 * PayPal is enable or not.
	 */
	private function is_paypal_enable()
	{
		$this->load->model('Pay_model');
		$paypalSetting = $this->Pay_model->getPaypalSettings();
		$scf_paypal = $paypalSetting['data'];
		// Paypal active on site or not.
		$paypal_activeos = ($scf_paypal->activeos == 1) ? 1 : 0;

		return $paypal_activeos;
	}

	/**
	 * Get product detail by category name and quantity.
	 */
	private function get_product_detail($qty, $category, $sCate_slug)
	{
		$this->load->model('Services_model');
		$package = $this->Services_model->getPackageBySubCategory($category["id"], $sCate_slug, $qty);
		// $pckg = ($package['success'] == 1) ? $package['data'] : array();
		return $package;
	}

	private function get_packages_for_subCategory($category, $sCate_slug)
	{
		$this->load->model('Services_model');
		$packages = $this->Services_model->getAllPackagesBySubCategory($category["id"], $sCate_slug);
		// $packages = ($packagesRecord['success'] == 1) ? $packagesRecord['data'] : array();
		// Define url for all packages
		foreach ($packages as $pkg => $value) {
			$packages[$pkg]["url"] = base_url() . "buy-{$value['packageQty']}-{$category['cat_slug']}-{$value['slug']}";
		}
		return $packages;
	}

	private function get_stripe_key()
	{
		$this->load->model('Pay_model');
		$stripeSettings = array();
		$stripeSetting = $this->Pay_model->get_stripe_data();
		if ($stripeSetting['success'] == 1) {
			$stripeSettings = $stripeSetting['data'];
		}
		return $stripeSettings;
	}

	private function prepare_view_data($pckg, $category)
	{
		// print_r($category['cat_slug']);
		// $where = array('most_viewed' => 1);
		// $this->mostViewd = $this->Services_model->getPackageList($where);

		// $packageId = scf_enc($pckg['packageQty'] . '|' . $pckg['serviceType']);
		$package_title = ($pckg->packagePrice > 0) ? 'Buy ' . $pckg->packageQty : 'Get ' . $pckg->packageQty;
		$package_title = $package_title . ' ' . $pckg->packageTitle;

		$data = array(
			'package' => $pckg,
			// 'mostViewd' => $this->mostViewd['result'],
			'title' => isset($pckg->page_title) ? $pckg->page_title : $package_title . " in UK || SocialFollowers"
		);
		$data = $this->viewDataAppPage($data, $pckg, $category);
		return $data;
	}

	private function viewDataAppPage($data, $pckg, $category)
	{
		// $paypal_enable = $this->is_paypal_enable();
		// $stripeSetting = $this->get_stripe_key();
		$pckgQty = $pckg->packageQty;
		$stype = $pckg->serviceType;
		// $data['packages'] = $packages;
		$data['packageTitle'] = $pckg->packageTitle;
		$data['priceUnit'] = $pckg->priceUnit;
		$data['packagePrice'] = $pckg->packagePrice;
		$data['packageQty'] = $pckgQty;
		$data['pckg_desc'] = array('second_description' =>  $pckg->second_description, 'third_description' =>  $pckg->third_description,);
		$data['serviceType'] = $stype;
		$data['limit'] = $this->getTypeAndLimit($category["cat_slug"], $stype);
		$data['is_auto'] = $this->is_auto_service($category["cat_slug"], $stype);
		$data['pageHeading'] = 'Buy <span>' . $pckg->packageQty . ' </span>' . $pckg->packageTitle;
		$data['free_services'] = $this->genral_model->getByColumnArray('free_services', 'id', $pckg->free_prod_id) ?? 0;
		// $data['find_fields_attr'] = array('id' => 'mobIgForm');
		$data = $this->createInputs($pckg, $data, $category);
		return $data;
	}

	public function getNameNdLimit($stype)
	{
		$limit = array(
			'comments' => array('serviceName' => 'Comments', 'limit' => 5),
			'likes' => array('serviceName' => 'Likes', 'limit' => 50),
			'views' => array('serviceName' => 'Views', 'limit' => 100),
			'storyviews' => array('serviceName' => 'Story Views', 'limit' => 100)
		);
		return isset($limit[$stype]) ? $limit[$stype] : array('serviceName' => $stype, 'limit' => 50);
	}

	private function createInputs($pckg, $data, $category)
	{
		if ($category["cat_slug"] == 'instagram') {
			$data['find_input'] = array(
				'id' => 'ig_username',
				'label' => 'Instagram Username',
				'placeholder' => 'Insta username without @ sign e.g. natgeo',
			);
			return $data;
		} else {
			switch ($category["cat_slug"]) {
				case 'tiktok':
					$inputData = $this->get_Tiktok_input_data($pckg, $category);
					$data["find_input"] = $inputData;
					return $data;
				case 'facebook':
					$inputData = $this->get_Facebook_input_data($pckg, $category);
					$data["find_input"] = $inputData;
					return $data;
				case 'youtube':
					$inputData = $this->get_Youtube_input_data($pckg, $category);
					$data["find_input"] = $inputData;
					return $data;
				default:
					break;
			}
		}
	}
	private function get_Tiktok_input_data($pckg, $category)
	{
		$input = array();
		if ($this->is_auto_service($category["cat_slug"], $pckg->slug)) {
			$input = array(
				'id' => 'url',
				'label' => 'Tiktok Profile Link',
				'placeholder' => 'https://www.tiktok.com/@username',
			);
		} else {
			$input = array(
				'id' => 'url',
				'label' => 'Tiktok Video Link',
				'placeholder' => 'https://www.tiktok.com/@username/video/12345678',
			);
		}
		return $input;
	}
	private function get_Facebook_input_data($pckg, $category)
	{
		if ($this->is_auto_service($category["cat_slug"], $pckg->slug)) {
			$input = array(
				'id' => 'url',
				'label' => 'Facebook Page Link',
				'placeholder' => 'e.g. https://www.facebook.com/Meta/',
			);
		} else {
			$input = array(
				'id' => 'url',
				'label' => 'Facebook Post Link',
				'placeholder' => 'e.g. https://www.facebook.com/873734106114534/posts/4382983058417714/',
			);
		}
		return $input;
	}
	private function get_Youtube_input_data($pckg, $category)
	{
		if ($this->is_auto_service($category["cat_slug"], $pckg->slug)) {
			$input = array(
				'id' => 'url',
				'label' => 'Youtube Channel Link',
				'placeholder' => 'e.g. https://www.youtube.com/c/NatGeo',
			);
		} else {
			$input = array(
				'id' => 'url',
				'label' => 'Youtube Video Link',
				'placeholder' => 'e.g. https://www.youtube.com/watch?v=7MFKy7DJsCY',
			);
		}
		return $input;
	}


	public function unsetSession()
	{
		$array_items = array(
			'discount_percent',
			'discount_price',
			'package_detail',
			'selected_posts',
			'orignal_price',
			'profile_photo',
			'order_detail',
			'ppl_products',
			'profile_data',
			'likePostIds',
			'requestData',
			'ppl_charges',
			'orderInsId',
			'price_paid',
			'used_trial',
			'promoCode',
			'load_more',
			'imagesrc',
			'discount',
			'promo',
			'token', 'order_items', 'cart'
		);

		$this->session->unset_userdata($array_items);
	}
	public function redirect_to_orignal()
	{
		$url_segments = $this->uri->segment(1);
		$url_segments_array = explode('-', $url_segments);
		if ($url_segments_array[2] == 'english') {
			$url_segments_array[2] = "uk";
		}
		$category = $url_segments_array[1];
		$serviceType1 = $url_segments_array[2];
		$serviceType2 = $url_segments_array[3];

		$serviceType = $serviceType1 . $serviceType2;
		redirect("buy-{$category}-{$serviceType}");
	}
}
