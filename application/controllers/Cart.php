<?php
class Cart extends CI_Controller 
{
    public $postData;
    public $cartDetail;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('instapi');
		$this->load->model('Mob_admin');
		$this->load->model('Users');
		$this->load->library('stripemanagerCart');
        $this->postData = $this->cleanPostData();
        $this->cartDetail  = $this->session->userdata('cart') ?? array();
    }

    public function index()
    {
        echo 'Hello World!';
    }

    public function add_to_cart()
    {
        $prodData = $this->prepareProdData();
        $cart = array('success' => 0, 'message' => 'There is an error. Try again.');
        if (!empty($prodData)) {
            $_SESSION['cart']['items'][] = $prodData;
            $this->calTotalAmount();
            if (isset($_SESSION['discount']) && isset($_SESSION['discount']['promoCode'])) {
                $promocode = $_SESSION['discount']['promoCode'];
                $this->applyPromo($promocode);
            }
            $cart = array('success' => 1, 'message' => 'Product is added to cart successfully.');
        }
        exit(json_encode($cart));

    }

    private function prepareProdData()
    {
    	$session = $_SESSION;
        if (!isset($session['package_detail'])) {
            return array();
        }
        $pckg = $session['package_detail'];
        $pckg = (array) $pckg;  //type casting object to array

        $res = array(
            'service_id' => $pckg['service_id'],
            'service_detail' => array(
                'packageTitle' => $pckg['packageTitle'],
                'packageId' => $pckg['id'],
                'packageQty' => $pckg['packageQty'],
                'serviceType' => $pckg['serviceType'],
            ),
            'amount_payable' => $pckg['packagePrice'],
            'priceUnit' => $pckg['priceUnit'],
        );
		//echo "<pre>";print_r($res);exit;
        $username_pkgs = ['followers', 'autolikes', 'autoviews'];
        $user_posts_pkgs = ['likes', 'views','comments'];

        if (in_array($pckg['serviceType'], $username_pkgs)) 
        {
			$res['user_name'] = $session['user_name'];
            $res['item_type'] = 1;
            if (isset($this->postData['selected_posts'])) {
                $res['selected_posts'] = $this->postData['selected_posts'];
            }
        }
        if (in_array($pckg['serviceType'], $user_posts_pkgs))
        {
            /*$is_auto = $this->is_auto_service("tiktok", $pckg["slug"]);
            if ($is_auto) {
                $res['url'] = $this->postData['platforms_url'];
                $res['item_type'] = 3;
            } else */
			if (isset($this->postData['selected_posts'])) {
				$selected_posts = $this->postData['selected_posts'];
				/*echo "<pre>";print_r($selected_posts);exit;
                $url = $selected_posts["url"];
                $res['url'] = $url["post_id"];*/
                $res['selected_posts'] = $selected_posts;
            }
        }
        if($pckg['serviceType'] === 'comments')
        {
        	$res['selected_posts'] = $this->prepareComments($pckg);
        }

        return $res;
    }

    public function calTotalAmount()
    {
        $items = $_SESSION['cart']['items'];
        $totalAmount = array_sum(array_column($items, 'amount_payable'));
        $_SESSION['cart']['total_amount'] = $totalAmount;
    }

    public function applyPromo($promoCode = '')
    {
        //echo "promo here";exit;
    	if (isset($_SESSION['discount'])) {
            unset($_SESSION['discount']);
        }
        $promo = ($promoCode == '') ? $this->postData['promo'] : $promoCode;

        $this->load->library('Promoinsta');
        $promoRes = $this->promoinsta->findPromo($promo);
        $data = $this->calculateDiscount();
		if (!empty($data)) {
            $promoRes = array('success' => 1, 'data' => $data);
        }
        exit(json_encode($promoRes));
    }

    public function calculateDiscount()
    {
        $data = array();
        if (isset($_SESSION['discount']) && $_SESSION['discount']['discount_percent'] > 0) {
            $discountPercent = $_SESSION['discount']['discount_percent'];
            $cartPrice = $_SESSION['cart']['total_amount'];
            $discountPrice = $cartPrice * $discountPercent / 100;   // Discount in amount
            $offPrice = round($discountPrice, 2);
            $discount_price = $cartPrice - $offPrice;           // Amount after discount
            $discountedPrice = round($discount_price, 2);
            $_SESSION['discount']['discountPercent'] = $discountPercent;
            $_SESSION['discount']['discountPrice'] = $offPrice;
            $_SESSION['discount']['discount_pkgprice'] = $discountedPrice;
            $data = $_SESSION['discount'];
        }
        return $data;
    }

    public function cleanPostData()
    {
        $postData = $_POST;
        if (!empty($_POST) && isset($_POST)) {
            foreach ($_POST as $key => $post) {
                $postData[$key] = $this->security->xss_clean($_POST[$key]);
            }
        }
        return $postData;
    }

    public function actionHandler()
    {
        $post = $this->postData;
        if (isset($post['act'])) {
            $act = $post['act'];
            switch ($act) {
                case 'remove_cart_prod':
                    $this->remove_prod();
                    break;
                case 'applypromo':
                    $this->applyPromo();
                    break;
                // case 'proceePayment':
                //     $this->setStripeCartSession();
                //     break;
            }
        }
    }

    public function remove_prod()
    {
        $productId = $this->postData['prod_id'];
        if (empty($_SESSION['cart'])) {
            $res = array('success' => 0, 'message' => 'Cart is already empty.');
        }
        if (isset($_SESSION['cart']['items'][$productId])) {
            $cart = $_SESSION['cart']['items'];
            unset($cart[$productId]);
            $sortedArray = array_values($cart);
            $_SESSION['cart']['items'] = $sortedArray;
            $this->calTotalAmount();
            if (isset($_SESSION['discount']) && isset($_SESSION['discount']['promoCode'])) {
                $promocode = $_SESSION['discount']['promoCode'];
                $this->applyPromo($promocode);
            }
            $res = array('success' => 1);
        } else {
            $res['message'] = 'Reload the page and try again.';
        }
        exit(json_encode($res));
    }

    public function checkout()
    {
		//echo "<pre>";print_r($this->session->all_userdata());exit;
		$this->load->helper('file');
    	if(isset($_GET['session']))
        {
            echo "<pre>";print_r($this->session->all_userdata());exit;
        }
		$stripeSettings = $this->stripemanagercart->get_stripe_setting();
    	if (isset($this->postData['act'])) {
            $this->actionHandler();
            $this->remove_prod();
        }
        $cartData = (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) ? $_SESSION['cart'] : array();
        $discount = isset($_SESSION['discount']) ? $_SESSION['discount'] : array();
        $data = array('cartData' => $cartData, 'discount' => $discount);
        $data["title"] = "Cart Page | Tiktok likes";
		$data["stripe_key"] = $stripeSettings->stripePublishableKey;
        // echo "<pre>";print_r($data);exit;

        $this->load->view('cart/checkout', $data);
    }
	public function setStripeCartSession()
	{
		if (!isset($this->postData['user_email'])) {
			exit(json_encode(array('success' => 0, 'message' => 'Email is required.')));
		}
		$this->session->set_userdata('user_email', $this->postData['user_email']);
		//echo "<pre>";print_r($this->session->userdata('user_email'));exit;
		$this->cartDetail = $_SESSION['cart'];
		$user_email = $this->session->userdata('user_email');
		$this->saveCartOrderData(); //Save initial data to database
		$stripRow = $this->Users->getStripeCustomer($user_email);
		$strpCustId = (!empty($stripRow) && $stripRow['success'] == 1) ? $stripRow['customer_id'] : '';
		$this->session->set_userdata('customer_id', $strpCustId);
		$return = array('success' => 1);
		// echo json_encode($return);
		exit(json_encode($return));
	}

	public function saveCartOrderData()
	{
		$newOrderId = $this->session->userdata('new_order');
		$pckg = $this->session->package_detail;
		$pckg = (object) $pckg;
		$order_resp = $this->Mob_admin->getCartOrderByOrderId($newOrderId);
		if ($order_resp["success"] === 1) {
			$order_data = $order_resp["data"];
			$save_order_id = $order_data["order_id"];
			if ($newOrderId == $save_order_id) {
				$orderId = time() . $pckg->service_id;
				$newOrderId = $orderId;
				$_SESSION['new_order'] = $newOrderId;
			}
		}
		$orderDetail = array(
			'order_id' => $newOrderId,
			'user_email' => $_SESSION['user_email'],
			'date' => date("Y-m-d H:i:s"),
			'order_status' => 'pending',
			'payment_status' => 'initiated'
		);
		$insertId = $this->Mob_admin->insertOrderInfo('mob_cart_order', $orderDetail);
		$_SESSION['orderInsId'] = $insertId;
		$this->saveCartOrderItemData(); //Save order item to database
	}

	public function saveCartOrderItemData()
	{
		$cart = $this->cartDetail;
		foreach ($cart['items'] as $items) {
			$orderItemDetail = array(
				'order_id' => $_SESSION['new_order'],
				'user_name' => isset($items['user_name']) ? $items['user_name'] : $items['url'],
				'service_id' => $items['service_id'],
				'service_type' => $items['service_detail']['serviceType'],
				'package_id' => $items['service_detail']['packageId'],
				'package_quantity' => $items['service_detail']['packageQty']
			);
			$item_insert_id =  $this->Mob_admin->insertOrderInfo('cart_order_items', $orderItemDetail);
			if (isset($items['selected_posts'])) {
				foreach ($items['selected_posts'] as $post) {
					$orderselected_posts = array(
						'order_id' => $_SESSION['new_order'],
						'quantity' => $post['quantity'],
						'post_id' => isset($post['post_id']) ? $post['post_id'] : $post['link'],
						'comments' => (isset($post['post_comments'])) ? $post['post_comments'] : '',
						'order_item_id' => $item_insert_id
					);
					$this->Mob_admin->insertOrderInfo('cart_order_selected_post', $orderselected_posts);
				}
			}

		}
	}

	public function sessionstripeCart()
	{
		$this->load->helper('file');
		$response = $this->stripemanagercart->setStripeSession();
		exit(json_encode($response));
	}
	public function stripeSuccess()
	{
		$this->load->helper('file');
		$statusMsg = '';
		$stripeSettings = $this->stripemanagercart->get_stripe_setting();
		// Check whether stripe checkout session is not empty
		if (!empty($_GET['session_id'])) {
			$session_id = $_GET['session_id'];

			// Include Stripe PHP library
			require_once(__DIR__ . '/../third_party/stripe-php/init.php');

			// Set API key
			\Stripe\Stripe::setApiKey($stripeSettings->stripeSecretKey);

			// Fetch the Checkout Session to display the JSON result on the success page
			try {
				$checkout_session = \Stripe\Checkout\Session::retrieve($session_id);
				$order_id = $checkout_session->metadata->new_order;
				$this->writefile($order_id, '$order_id');
				$this->writefile(json_encode($checkout_session->metadata), '$checkout_session->metadata');
				$this->writefile(json_encode($checkout_session), '$checkout_session');
				$_SESSION['new_order'] = $order_id;
			} catch (Exception $e) {
				$api_error = $e->getMessage();
			}
			if (empty($api_error) && $checkout_session) {
				// Retrieve the details of a PaymentIntent
				try {
					$intent = \Stripe\PaymentIntent::retrieve($checkout_session->payment_intent);
					$this->writefile(json_encode($intent), 'stripeSuccess intent');
				} catch (\Stripe\Exception\ApiErrorException $e) {
					$api_error = $e->getMessage();
					$this->writefile(json_encode($api_error), 'stripeSuccess api_error');
				}
				// Retrieves the details of customer
				try {
					// Create the PaymentIntent
					$customer = \Stripe\Customer::retrieve($checkout_session->customer);
					$this->writefile(json_encode($customer), 'stripeSuccess customer');
				} catch (\Stripe\Exception\ApiErrorException $e) {
					$api_error = $e->getMessage();
					$this->writefile(json_encode($api_error), 'stripeSuccess api_error');
				}
				if (empty($api_error) && $intent) {
					// Check whether the charge is successful
					if ($intent->status == 'succeeded') {
						// Customer details
						$sucessResult['name'] = $customer->name;
						$sucessResult['customer_id'] = $customer->id;
						$sucessResult['email'] = $customer->email;
						// Transaction details
						$paidAmount = $intent->amount;
						$sucessResult['intentID'] = $intent->id;
						$sucessResult['charge_id'] = $intent->charges->data[0]->id;
						$sucessResult['paidAmount'] = ($paidAmount / 100);
						$sucessResult['paymentStatus'] = $intent->status;
						$sucessResult['receipt_url'] = $intent->charges->data[0]->receipt_url;
						$sucessResult['stripe_txn_id'] = $intent->charges->data[0]->balance_transaction;
						$sucessResult['transaction_date'] = $intent->charges->data[0]->created;
						$sucessResult['stripe_payment_method'] = $intent->charges->data[0]->payment_method_details->type;
						$sucessResult['last4'] = $intent->charges->data[0]->payment_method_details->card->last4;
						$this->writefile(json_encode($sucessResult), 'stripeSuccess sucessResult');
						$this->stripemanagercart->insertStripeTransactionDetail($sucessResult);
						$stripe_data = $this->stripemanagercart->prepareStripeDataAfterSuccess($sucessResult);
						$this->writefile(json_encode($stripe_data), 'stripeSuccess stripe_data');
						$this->buyRequest($stripe_data);
						$this->writefile('after stripeSuccess buyRequest', 'after stripeSuccess buyRequest');
						// If the order is successful
						if ($intent->status == 'succeeded') {
							$statusMsg = 'Your Payment has been Successful!';
							$this->session->set_flashdata('success', $statusMsg);
						} else {
							$statusMsg = "Your Payment has failed!";
							$this->session->set_flashdata('error', $statusMsg);
						}
					} else {
						$statusMsg = "Transaction has been failed!";
						$this->session->set_flashdata('error', $statusMsg);
					}
				} else {
					$statusMsg = "Unable to fetch the transaction details! " . $api_error;
					$this->session->set_flashdata('error', $statusMsg);
				}
				$ordStatus = 'success';
			} else {
				$statusMsg = "Transaction has been failed!" . $api_error;
				$this->session->set_flashdata('error', $statusMsg);
			}
			$this->writefile(json_encode($statusMsg), 'stripeSuccess statusMsg');
		} else {
			$statusMsg = "Invalid Request!";
			$this->session->set_flashdata('error', $statusMsg);
			redirect(base_url('order-cancel'));
		}
	}

	public function buyRequest($data = array())
	{
		$this->load->library('cartservice');
		$this->cartservice->getSessionFromDB();
		$final_result = $this->cartservice->prepareRequestOfCart();
		//echo "<pre>";print_r($final_result);exit;
		$response = $this->cartservice->multiRequests($final_result);
		$data['updated_order'] = $response;
		$this->updateOrderData($data);
		$this->notifyEmail();
		$order_id = $_SESSION['new_order'];
		header('location: ' . base_url('/multi_order_success/' . $order_id));
	}
	private function notifyEmail()
	{
		$orderStr = $_SESSION['order_items'];
		$order_id = $_SESSION['new_order'];
		$orders = $orderStr; //json_decode($orderStr, true);
		$intOrderIds = array_map(function ($value) {
			return intval($value);
		}, $orders);
		$stringExists = in_array(0, $intOrderIds, true);
		if ($stringExists) {
			$dataMail = array(
				'subject' => 'Order #' . $order_id . ' Failed.',
				'to' => 'toseefhasan@gmail.com',
				'message' => 'Error: ' . json_encode($orderStr)
			);
			$this->load->library('mobemail');
			$this->mobemail->mobNotifyMail($dataMail);
		}
	}

	public function updateOrderData($response = array())
	{
		$orderUpdatedDetail = array(
			'stripe_transaction_id' => $response['stripe_transaction_id'],
			'payment_status' => $response['payment_status'],
			'amount_paid' => isset($_SESSION['price_paid']) ? $_SESSION['price_paid'] : '',
			'gateway' => $response['gateway']
		);
		if (isset($_SESSION['new_order'])) {
			$insId = $_SESSION['new_order'];
			$this->Mob_admin->updateOrderInfo('mob_cart_order', $insId, $orderUpdatedDetail);
		} else {
			$this->Mob_admin->insertOrderInfo('mob_cart_order', $orderUpdatedDetail);
		}

		$orders = $response['updated_order'];
		foreach ($orders as $order) {
			$postDataArray = array('api_order_id' => $order['result']);
			    if ($order['cart_order_selected_id'] != '') {
					$where = array('id' => $order['cart_order_selected_id']);
					$this->Mob_admin->updateOrderItemInfo('cart_order_selected_post', $where, $postDataArray);
					$_SESSION['selected_posts'] = true;
				} else {
					$where = array('id' => $order['order_item_id']);
					$this->Mob_admin->updateOrderItemInfo('cart_order_items', $where, $postDataArray);
				}

		}
	}

	public function writefile($string, $heading)
	{
		$logsPath = FCPATH . 'application/views/logs/' . date("Y-m-d") . '/';
		$filesize =  (file_exists($logsPath . 'logs.php')) ? filesize($logsPath . 'logs.php') : 0;
		if (!file_exists($logsPath)) {
			mkdir($logsPath, 0777, true);
		}
		if ($filesize > 72343) {
			$time = time();
			rename($logsPath . 'logs.php', $logsPath . 'logs_' . $time . '.php');
		}
		@write_file($logsPath . 'logs.php', '<h2>' . $heading . '</h2><p> ' . $string . "</p> \r\n", 'a');
	}

	public function prepareComments($pckg)
    {
        $commentsArray = $this->postData['com'];
        $comments_data = array();
        foreach ($commentsArray as $postId => $value) {
            $commentString = "";
            $sprt = "";
            $post = array();
            foreach ($value as $comment) {
                $commentString .= $sprt . trim($comment['comment']);
                $qty =  $comment['quantity'];
                $link =  isset($comment['post_id']) ? $comment['post_id'] : "";
                $sprt = "\n";
            }
            // $post['post_id'] = str_replace("box", "", $postId);
            // $post['post_id'] = str_replace("box", "", $postId);
            // if (strpos($pckg['packageTitle'], 'Instagram') !== false) {
            // }
            $post['post_comments'] = $commentString;
            $post['quantity'] = $qty;
            $post['post_id'] = $link;

            $comments_data[] = $post;
        }
        return $comments_data;
    }



}
