<?php
class Cart extends CI_Controller 
{
    public $postData;
    public $cart_details;
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('instapi');
		$this->load->model('Mob_admin');
        $this->postData = $this->cleanPostData();
        $this->cart_details = $this->session->userdata('cart') ?? array();
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
        else if (in_array($pckg['serviceType'], $user_posts_pkgs))
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
        else if($pckg['serviceType'] === 'comments')
        {

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
        if (isset($this->postData['act'])) {
            $this->actionHandler();
            $this->remove_prod();
        }
        $cartData = (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) ? $_SESSION['cart'] : array();
        $discount = isset($_SESSION['discount']) ? $_SESSION['discount'] : array();
        $data = array('cartData' => $cartData, 'discount' => $discount);
        $data["title"] = "Cart Page | Tiktok likes";
         
        // echo "<pre>";print_r($data);exit;

        $this->load->view('cart/checkout', $data);
    }
}
