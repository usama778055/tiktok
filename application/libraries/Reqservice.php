<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(E_ALL);

class Reqservice
{
	private $_CI;
	public $path;
	public function __construct()
	{
		$this->_CI = &get_instance();
		$this->_CI->load->model('Mob_admin');
		$this->path = "http://api.digitalaimz.com/request/";
		$this->_CI->load->helper('file');
	}

	public function writefile($string, $heading)
	{
		$logsPath = FCPATH . 'application/views/logs/' . date("Y-m-d") . '/';
		if (!file_exists($logsPath)) {
			mkdir($logsPath, 0777, true);
		}
		@write_file($logsPath . 'logs.php', '<h2>' . $heading . '</h2><p> ' . $string . "</p> \r\n", 'a');
	}

	public function prepareRequest()
	{
		$pckg = $_SESSION['package_detail'];
		$username = $_SESSION['user_name'];

		$data = array(
			array(
				'act' => 'place_order',
				'link' => "https://www.instagram.com/" . $username,
				'service_id' => $pckg['service_id'],
				'quantity' => $pckg['packageQty'],
				'user_name' => isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '',
				'user_email' => isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''
			)
		);

		$finalRequest = $this->additionalReqData($data);

		$this->writefile(json_encode($finalRequest), 'Request Array');
		return $finalRequest;
	}

	public function additionalReqData($data)
	{
		$pckg = $_SESSION['package_detail'];
		$sType = $pckg['serviceType'];
		$selectedPost = isset($_SESSION['selected_posts']) ? $_SESSION['selected_posts'] : array();
		$postLVArray = array('likes', 'views', 'igtvviews', 'storyviews', 'comments');
		if (in_array($sType, $postLVArray) && !empty($selectedPost)) {
			$data = array();
			foreach ($selectedPost as $post) {
				$data[] = $this->preparePostData($pckg, $post);
			}
		} else if (strpos($sType, "auto") !== False) {
			$data = array();
			$data[] = $this->prepareSubsData($pckg);
		}

		return $data;
	}

	public function preparePostData($pckg, $post)
	{
		if ($pckg['serviceType'] == 'storyviews') {
			$link = "https://www.instagram.com/stories/highlights/" . $post['post_id'];
		} else {
			$link = "https://www.instagram.com/p/" . $post['post_id'];
		}

		$dataArray = array(
			'act' => 'place_order',
			'link' => $link,
			'service_id' => $pckg['service_id'],
			'quantity' => isset($post['post_like']) ? $post['post_like'] : '',
			'user_name' => isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '',
			'user_email' => isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''
		);
		if ($pckg['serviceType'] == 'comments') {
			$comments = $post['post_comments'];
			$dataArray['quantity'] = isset($post['comment_qty']) ? $post['comment_qty'] : '';
			$dataArray['comments'] = $comments;
		}

		return $dataArray;
	}

	public function prepareSubsData($pckg)
	{
		$username = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
		$min = $pckg['packageQty'];
		$max = $min + 25;

		$resArray = array(
			'act' => 'place_order',
			'username' => $username,
			'service_id' => $pckg['service_id'],
			'min' => $min,
			'max' => $max,
			'posts' => 30,
			'delay' => 0,
			'user_name' => $username,
			'user_email' => isset($_SESSION['user_email']) ? $_SESSION['user_email'] : ''
		);

		return $resArray;
	}

	public function placeFreeOrder()
	{

		$user_name = $_SESSION['user_name'];
		$profile_id = $_SESSION['profile_data']['profile_id'];

		$allowTrial = $this->allowTrial($user_name, $profile_id);

		if ($allowTrial == 1 || $this->_CI->session->userdata('user_email') == 'fineartfoto@libero.it') {
			return true;
		} else {
			$this->_CI->session->set_flashdata('error', 'You have already used free trial.');
			$previous = $_SERVER['HTTP_REFERER'];
			redirect($previous);
		}
	}

	private function allowTrial()
	{
		$allowed = 0;
		$profileId = $_SESSION['profile_data']['profile_id'];
		$userName = $_SESSION['user_name'];
		$ip_address = $_SERVER['REMOTE_ADDR'];

		$usedRes = $this->_CI->Mob_admin->getFreeRow($userName, $profileId, $ip_address);
		$data = array('sender_user_id' => $userName, 'status' => 2, 'used' => 0);
		$awarded = $this->_CI->Mob_admin->getInvitePackage($data);

		if ($usedRes['success'] == 0 || $awarded['success'] == 1) {
			$allowed = 1;
			if ($awarded['success'] == 1) {
				$_SESSION['awardedRef'] = $awarded['data'][0];
			}
		}
		return $allowed;
	}

	public function placeOrder()
	{
		$reqData = $this->prepareRequest();
		$response = $this->multiRequests($reqData);
		$this->writefile(json_encode($response), 'Request Response: ');
		return $response;
	}

	public function trackOrder($orderId)
	{
		$findOrder = $this->_CI->Mob_admin->getOrder($orderId, array('order_id' => $orderId));
		if ($findOrder['success'] == 0) {
			return array('error' => 'Invalid order id.');
		}
		$orderRes = $findOrder['data'];
		$response = $this->trackOrderRes($orderRes);
		$final_data = array('seccess' => 0);
		if (!empty($response)) {
			if (!empty($response['orders']) && isset($response['orders'][0]['status'])) {
				$final_data = array('seccess' => 1, 'data' => array());
				foreach ($response['orders'] as $key => $track) {
					$url = $track['post_url'];
					$postId = basename($url);
					$final_data['data'][] = array(
						'start_count' =>  $track['start_count'],
						'status'      => $track['status'],
						'remains'     => $track['remains'],
						'post_link' => $url,
						'post_id' => $postId
					);
				}
			}
		}
		return $final_data;
	}
	public function trackMultiOrder($orderId)
	{
		$findOrder = $this->_CI->Mob_admin->getOrderItemByOrderId($orderId, array('order_id' => $orderId));
		if ($findOrder['success'] == 0) {
			return array('error' => 'Invalid order id.');
		}
		$orderRes = $findOrder['data'];
		$response = $this->trackOrderMultiRes($orderRes);

		$final_data = array('success' => 0);
		if (!empty($response)) {
			if (!empty($response['orders']) && isset($response['orders'][0]['status'])) {
				$final_data = array('success' => 1, 'data' => array());
				foreach ($response['orders'] as $key => $track) {
					$url = $track['post_url'];
					$postId = basename($url);
					$final_data['data'][] = array(
						'start_count' =>  $track['start_count'],
						'status'      => $track['status'],
						'remains'     => $track['remains'],
						'post_link' => $url,
						'post_id' => $postId
					);
				}
			}
		}
		return $final_data;
	}
	private function trackOrderMultiRes($orderRes)
	{
		$allDataArray = $this->generateMultiTrackRequest($orderRes);
		if (empty($allDataArray)) {
			return array();
		}
		$response = $this->multiRequests($allDataArray);

		return $response;
	}
	private function generateMultiTrackRequest($orderRes)
	{
		$allDataArray = array();
		foreach ($orderRes as $order) {
			$api_order_id = ($order['api_order_id'] != '') ? $order['api_order_id'] : $order['api_order_item_id'];
			if (!empty($api_order_id)) {
				$allDataArray[] = array(
					'act' => 'track_order',
					'order_id' => $api_order_id
				);
			}
		}
		return $allDataArray;
	}

	private function trackOrderRes($orderRes)
	{
		$allDataArray = $this->generateTrackRequest($orderRes);
		if (empty($allDataArray)) {
			return array();
		}
		$response = $this->multiRequests($allDataArray);

		return $response;
	}

	private function getPostData($orderRes, $track)
	{
		$orderId = $track['order_id'];
		$selectedPosts = json_decode($orderRes['selected_posts'], true);

		$index = array_search($orderId, array_column($selectedPosts, 'order_id', 'post_id'));

		$data['src'] = $selectedPosts[$index]['post_src'];
		$data['unq_id'] = $index;
		$data['imgId'] = $selectedPosts[$index]['post_id'];

		return $data;
	}

	private function generateTrackRequest($orderRes)
	{
		$resellerOrderIds = ($orderRes['multi_order'] != '') ? json_decode($orderRes['multi_order'], true) : array();
		$allDataArray = array();
		if (!empty($resellerOrderIds)) {
			for ($n = 0; $n < count($resellerOrderIds); $n++) {
				$allDataArray[] = array(
					'act' => 'track_order',
					'order_id' => $resellerOrderIds[$n],
					'reseller_id' => ($orderRes['reseller_id'] > 0) ? $orderRes['reseller_id'] : ''
				);
			}
		}

		return $allDataArray;
	}


	public function multiRequests($allDataArray)
	{
		$this->writefile(json_encode($allDataArray), '$allDataArray:');
		// array of curl handles
		$multiCurl = array();
		// data to be returned
		$result = array();
		// multi handle
		$mh = curl_multi_init();
		foreach ($allDataArray as $i => $package) {
			$fetchURL = 'https://devapi.digitalaimz.com/request/';
			$post = array();
			foreach ($package as $k => $v) {
				$post[] = $k . '=' . urlencode($v);
			}

			$authKey =  'u#3n2@r!';  //'k2@h$%a1';// 'u#3n2!r@';    // socialfollowers key 'k2@h$%a1'; //'b$b3V4s@1b';
			$header = array();
			$header[] = 'Authorization: OAuth ' . $authKey;

			$multiCurl[$i] = curl_init();
			curl_setopt($multiCurl[$i], CURLOPT_URL, $fetchURL);
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

		$index = 1;
		do {
			curl_multi_exec($mh, $index);
		} while ($index > 0);
		// get content and remove handles
		foreach ($multiCurl as $k => $ch) {
			$result[$k] = curl_multi_getcontent($ch);
			$res = json_decode($result[$k], true);
			if (isset($res['data'])) {
				if (is_array($res['data'])) {
					$result[$k] = $res['data'];
				} else {
					$orderId = json_decode($res['data'], true);
					if (isset($orderId['order'])) {
						$result[$k] = isset($orderId['order']) ? $orderId['order'] : '';
					} else {
						$result[$k] = isset($orderId['error']) ? $orderId['error'] : '';
					}
				}
			}

			$allDataArray[$k]['result'] = isset($res['data']) ? $res['data'] : array();
			curl_multi_remove_handle($mh, $ch);
		}
		// close
		curl_multi_close($mh);
		$allDataArray['orders'] = $result;
		return $allDataArray;
	}
}
