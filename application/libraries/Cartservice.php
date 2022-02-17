<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(E_ALL);

class Cartservice
{
	private $_CI;
	public $path;
	public $service_ids;

	public function __construct()
	{
		$this->_CI = &get_instance();
		$this->_CI->load->model('Mob_admin');
		$this->_CI->load->model('genral_model');
		$this->path = "http://api.digitalaimz.com/request/";

		// auto services array, e.g. autolikes
		$this->service_ids['auto_services'] = array(8, 9, 24, 25);
		// insta services ids
		//$this->service_ids['insta_services'] = array(1, 2, 3, 4, 10, 11, 12, 13, 14);
		// followers services
		$this->service_ids['follower_services'] = array(2, 10, 11, 16, 20, 21, 27, 28,);
		// service ids other than instagram
		$this->service_ids['other_services'] = array(16, 17, 18, 20, 21, 22, 23, 26, 27, 28, 29, 30);
	}

	public function getSessionFromDB()
	{
		if (isset($_SESSION['new_order'])) {
			$orderId = $_SESSION['new_order'];
			$orderRes =  $this->_CI->Mob_admin->getCartOrderByOrderId($orderId);
			$this->writefile(json_encode($orderRes), 'getSessionFromDB orderRes: ');
			$orderRow = ($orderRes['success'] == 1) ? $orderRes['data'] : '';
			$_SESSION['user_email'] = $orderRow['user_email'];
			$_SESSION['orderInsId'] = $orderRow['id'];

			$orderItemRes =  $this->_CI->Mob_admin->getOrderItemByOrderId($orderId);
			//$orderItemFreeServices =  $this->_CI->Mob_admin->getOrderItemFreeServicesByOrderId($orderId);
			$this->writefile(json_encode($orderItemRes), 'getSessionFromDB orderItemRes: ');
			//$this->writefile(json_encode($orderItemFreeServices), 'getSessionFromDB orderItemFreeServices: ');
			$orderItemRows = ($orderItemRes['success'] == 1) ? $orderItemRes['data'] : '';
			//$orderItemFreeRows = ($orderItemFreeServices['success'] == 1) ? $orderItemFreeServices['data'] : '';
			$_SESSION['order_items'] = $orderItemRows;
			//$_SESSION['order_items_free_services'] = $orderItemFreeRows;
		}
	}

	public function prepareRequestOfCart()
	{
		$order_items = $_SESSION['order_items'];
		$data = array();
		foreach ($order_items as $item) {
			$data[] = $this->prepare_items_data($item);
		}
		return $data;
	}

	public function prepare_items_data($item)
	{
		$user_name = (in_array($item['service_id'], $this->service_ids['other_services'])) ? 'service_' . $item['service_id'] : $item['user_name'];
		$dataArray = array(
			'act' => 'place_order',
			'service_id' => $item['service_id'],
			'user_name' => $user_name,
			'quantity' => ($item['quantity'] > 0) ? $item['quantity'] : $item['package_quantity'],
			//'user_email' => isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '',
			 'user_email' => 'nelsonmtaylor336@gmail.com',
			'order_item_id' => $item['item_id'],
			'cart_order_selected_id' => $item['cart_order_selected_id'],
		);
		$dataArray = $this->prepare_data_by_service($dataArray, $item);
		if (isset($dataArray['link']))
			$dataArray['link'] = urlencode($dataArray['link']);

		$dataArray['user_name'] = urlencode($dataArray['user_name']);
		return $dataArray;
	}

	public function prepare_data_by_service($data, $item)
	{
		$sid = $item['service_id'];

		// if in followers array
		if (in_array($sid, $this->service_ids['follower_services'])) {
			$data["quantity"] = $item["package_quantity"];
		}
		if ($sid == 23) {
			$data['comments'] = $item['comments'];
		}
		// if subscription service
		if (in_array($sid, $this->service_ids['auto_services'])) {
			$username = $item['user_name'];
			$min = $item['package_quantity'];
			$max = $min + 25;
			$data['min'] = $min;
			$data['max'] = $max;
			$data['posts'] = 30;
			$data['delay'] = 0;
			$data['username'] = $username;
		}
		// if not Insta subscription service
		/*else if (in_array($sid, $this->service_ids['insta_services'])) {
			$data['link'] = $this->get_link_by_sId($item);
			// if includes comments
			if ($sid == 1) {
				$data['comments'] = $item['comments'];
			}
		}*/

		// if Other service e.g. tiktok, facebook etc.
		else if (in_array($sid, $this->service_ids['other_services'])) {
			$data['link'] = isset($item["post_id"]) ? $item["post_id"] : $item["user_name"];
		}
		return $data;
	}

	public function get_link_by_sId($item)
	{
		$sid = $item['service_id'];
		// Instagram followers,
		// set link to https://instagram.com/username
		if ($sid == 2) {
			$link = IG_URL . $item['user_name'];
		}
		// Instagram stories
		// e.g. https://instagram.com/stories/highlights/post_id
		else if ($sid == 13) {
			$link = IG_URL .  "stories/highlights/" . $item['post_id'];
		}
		// IGTV
		// e.g. https://instagram.com/tv/post_id
		else if ($sid == 12) {
			$link = IG_URL .  "tv/" . $item['post_id'];
		}
		// Instagram posts
		// e.g. https://instagram.com/p/post_id
		else {
			$link = IG_URL .  "p/" . $item['post_id'];
		}
		return $link;
	}

	private function prepare_free_items($item)
	{
		$dataArray = array(
			'act' => 'place_order',
			'link' => urlencode($item['link']),
			'service_id' => $item['service_id'],
			'quantity' => $item["package_quantity"],
			'user_name' => 'freeservice',
			// 'user_email' => isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '',
			'user_email' => 'nelsonmtaylor336@gmail.com',
			'order_item_id' => $item['item_id'],
			'cart_order_selected_id' => $item['cart_order_selected_id']
		);
		return $dataArray;
	}

	// public function preparePostData($item)
	// {
	//     if ($item['service_type'] == 'storyviews') {
	//         $link = IG_URL."stories/highlights/" . $item['post_id'];
	//     } else {
	//         $link = IG_URL."p/" . $item['post_id'];
	//     }
	//     $dataArray = array(
	//         'act' => 'place_order',
	//         'link' => $link,
	//         'service_id' => $item['service_id'],
	//         'quantity' => isset($item['quantity']) ? $item['quantity'] : '',
	//         'user_name' => $item['user_name'],
	//         // 'user_email' => 'nelsonmtaylor336@gmail.com',
	//         'user_email' => isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '',
	//         'order_item_id' => $item['item_id'],
	//         'cart_order_selected_id' => $item['cart_order_selected_id']
	//     );
	//     if ($item['service_type'] == 'comments') {
	//         $dataArray['comments'] = $item['comments'];
	//     }
	//     return $dataArray;
	// }

	// public function prepareSubsData($item)
	// {
	//     $username = $item['user_name'];
	//     $min = $item['package_quantity'];
	//     $max = $min + 25;
	//     $resArray = array(
	//         'act' => 'place_order',
	//         'username' => $username,
	//         'service_id' => $item['service_id'],
	//         'min' => $min,
	//         'max' => $max,
	//         'posts' => 30,
	//         'delay' => 0,
	//         'user_name' => $username,
	//         // 'user_email' => 'nelsonmtaylor336@gmail.com',
	//         'user_email' => isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '',
	//         'order_item_id' => $item['item_id'],
	//         'cart_order_selected_id' => $item['cart_order_selected_id']
	//     );

	//     return $resArray;
	// }

	public function multiRequests($allDataArray)
	{
		// array of curl handles
		$multiCurl = array();
		// data to be returned
		$result = array();
		// multi handle
		$mh = curl_multi_init();

		if (!empty($allDataArray)) {
			foreach ($allDataArray as $i => $package) {
				$post = array();
				foreach ($package as $k => $v) {
					$post[] = $k . '=' . urlencode($v);
				}
				$header = array();
				$header[] = 'Authorization: OAuth ' . SF_API_KEY;

				$multiCurl[$i] = curl_init();
				curl_setopt($multiCurl[$i], CURLOPT_URL, SF_API_URL . '/request/');
				curl_setopt($multiCurl[$i], CURLOPT_HTTPHEADER, $header);
				curl_setopt($multiCurl[$i], CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($multiCurl[$i], CURLOPT_POST, 1);
				curl_setopt($multiCurl[$i], CURLOPT_HEADER, 0);
				curl_setopt($multiCurl[$i], CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($multiCurl[$i], CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($multiCurl[$i], CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($multiCurl[$i], CURLOPT_POSTFIELDS, join('&', $post));
				curl_setopt($multiCurl[$i], CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
				curl_multi_add_handle($mh, $multiCurl[$i]);
			}
		}

		$index = 1;
		do {
			curl_multi_exec($mh, $index);
		} while ($index > 0);
		foreach ($multiCurl as $k => $ch) {
			$result[$k] = curl_multi_getcontent($ch);
			$this->writefile($result[$k], 'multiRequests.orderRes: ');
			$res = json_decode($result[$k], true);
			$apiResData = $result[$k];
			if (isset($res['data'])) {
				if (is_array($res['data'])) {
					$orderData = $res['data'];
				} else {
					$orderData = json_decode($res['data'], true);
				}

				$apiResData = (isset($orderData['order'])) ? $orderData['order'] : (isset($orderData['error']) ? $orderData['error'] : '');
			}
			$allDataArray[$k]['result'] = $apiResData;
			curl_multi_remove_handle($mh, $ch);
		}
		// close
		curl_multi_close($mh);
		return $allDataArray;
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
}
