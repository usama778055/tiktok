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
        $this->load->library('instapi');
        $this->postData = $this->cleanPostData();
        $this->cart_details = $this->session->userdata('cart') ?? array();
    }

    public function index()
    {
        echo 'Hello World!';
    }

    public function add_to_cart()
    {

    	//echo "<pre>";print_r($this->session->all_userdata());exit;
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

        // if($this->input->post('username'))
        // {
        //     //followers etc
        //     $username = $this->input->post('username');
        //     $user_data = $this->instapi->get_tiktok_user($username);
        // }
        // else if($this->input->post('userData'))
        // {
        //     //selected posts etc
        //     $user_data = $this->instapi->get_tiktok_user($username);

        // }
        // $this->cart_details = ['someting'];
        // print_r($user_data);
    }

    private function prepareProdData()
    {
       //echo "<pre>";print_r($this->session->all_userdata());exit;
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
			echo "selected user pkg in";exit;
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
				echo "selected in";exit;
                $selected_posts = $this->postData['selected_posts'];
                $url = $selected_posts["url"];
                $res['url'] = $url["post_id"];
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
        if (isset($_SESSION['discount'])) {
            unset($_SESSION['discount']);
        }
        $promo = ($promoCode == '') ? $this->postData['promo'] : $promoCode;

        $this->load->library('Promoinsta');
        $promoRes = $this->promoinsta->findPromo($promo);
        if ($promoRes['success'] == 0) {
            exit(json_encode($promoRes));
        }
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
            $discount_price      = $cartPrice - $offPrice;           // Amount after discount
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

    public function checkout()
    {
        $this->load->view('cart/checkout');
    }
}
