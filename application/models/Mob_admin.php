<?php

/**
 *
 */
class Mob_admin extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	function getEmailList($month = '')
	{
		$return = array('success' => 0);
		$prvMonth = date('Y-m', strtotime("-1 month")); // 2019-05
		$monthYear = ($month == '') ? $prvMonth : $month;
		$sql = 'SELECT user_email FROM `mob_ig_orders` WHERE date LIKE "' . $monthYear . '%" GROUP BY user_email';
		$result = $this->db->query($sql);
		$error = $this->db->error();
		if ($error['code'] == 0 && $result->num_rows() > 0) {
			$return = array('success' => 1, 'data' => $result->result_array());
		}
		return $return;
	}

	function get_pending_orders($where)
	{
		$return = array('success' => 0);
		$this->db->where($where);
		$this->db->select('order_id, multi_order, service_type');
		$result = $this->db->get('mob_ig_orders');
		$error = $this->db->error();
		if (isset($_GET['updQueryDisp'])) {
			echo $this->db->last_query();
			exit;
		}

		$errNo = $error['code'];
		if ($errNo == 0 && $result->num_rows() > 0) {
			$return = array('success' => 1, 'data' => $result->result_array());
		}
		return $return;
	}

	function update_order_status_auto($query, $condition)
	{
		$update_query = "UPDATE mob_ig_orders SET order_status = CASE multi_order " . $query . "  END
                        WHERE order_id IN(" . $condition . ")";
		if (isset($_GET['updQueryDisp'])) {
			echo $update_query;
			exit;
		}
		$result = $this->db->query($update_query);
		$error = $this->db->error();
		$errNo = $error['code'];

		if ($errNo == 0) {
			$return = array('success' => 1, 'data' => $result);
		} else {
			$errMess = $error['message'];
			$return = array('success' => 0, 'msg' => $errMess);
		}
		return $return;
	}

	function getResellerSettings($where = "")
	{

		if ($where != "") {
			$sql = 'SELECT r.* FROM `reseller_settings` r
                        LEFT JOIN active_panel_service a ON a.panel_id = r.id
                        WHERE ' . $where . ' limit 1';
			$result = $this->db->query($sql);
		}
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			$return = array('success' => 1, 'data' => $result->result_array());
		} else {
			$return = array('success' => 0, 'msg' => $errMess, 'sql' => $sql);
		}
		return $return;
	}

	/**
	 * Get all the orders with payment status "iniated"
	 * @param type $limit (number of rows requested)
	 * @return array (Array of success)
	 */
	function getIniatedOrder($limit)
	{
		$date = date('Y-m-d', strtotime("-1 days"));
		$where = array('payment_status' => 'initiated', 'order_id != ' => '', 'date > ' => '2020-04-15');
		$this->db->where($where);
		$this->db->order_by("id", "desc");
		$this->db->limit($limit, 0);
		$result = $this->db->get('mob_ig_orders');
		$sql = $this->db->last_query();
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			$return = array('success' => 1, 'data' => $result->result_array(), 'sql' => $sql);
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}
		return $return;
	}

	/**
	 * Get all the orders with payment status "iniated"
	 * @param type $limit (number of rows requested)
	 * @return array (Array of success)
	 */
	function getreviews()
	{
		$where = array('active' => 1);
		$this->db->where($where);
		$this->db->order_by("id", "desc");
		$result = $this->db->get('reviews');
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			$return = array('success' => 1, 'data' => $result->result_array());
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}
		return $return;
	}

	/**
	 * Get single order witch payment status is sometimes = "iniated" and sometimes "iniated or emailsent".
	 * @param type $where   where string
	 * @return int  array result
	 */
	function getIniatedOrderById($where = '')
	{
		//        $where = array('payment_status' => 'initiated', 'order_id' => $orderId);  //, 'service_type' => 'followers'
		//        $where = "payment_status='initiated' OR payment_status='emailsent' AND order_id=".$orderId;
		$this->db->where($where);
		$this->db->order_by("id", "desc");
		//$this->db->group_by("user_name");
		$this->db->limit(50, 0);
		$result = $this->db->get('mob_ig_orders');
		$sql = $this->db->last_query();
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			$return = array('success' => 1, 'data' => $result->result_array(), 'sql' => $sql);
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}
		return $return;
	}
	//    function getIniatedOrderById($orderId='') {
	//        $where = array('order_id' => $orderId, 'payment_status' => 'emailsent');
	//        $this->db->where($where);
	//        $result = $this->db->get('mob_ig_orders');
	////        $sql = "SELECT * FROM `mob_ig_orders` WHERE payment_status = 'initiated' AND order_id = ".$orderId." ORDER BY id DESC LIMIT 1";
	////        $result = $this->db->query($sql);
	//
	//        $error = $this->db->error();
	//        $errNo = $error['code'];
	//        $errMess = $error['message'];
	//
	//        if ($errNo == 0 && $result->num_rows() > 0) {
	//            $return = array('success' => 1, 'data' => $result->result_array());
	//        } else {
	//            $return = array('success' => 0, 'msg' => $errMess, 'sql' => $sql);
	//        }
	//        return $return;
	//    }

	function updateOrderStatus($orderId, $status)
	{
		$this->db->where('order_id', $orderId);
		$update = $this->db->update('mob_ig_orders', array('order_status' => $status));
		return $update;
	}

	function updatePaymentStatus($orderId, $status)
	{
		$this->db->where('order_id', $orderId);
		$update = $this->db->update('mob_ig_orders', array('payment_status' => $status));
		//return $this->db->last_query();
		return $update;
	}

	// function getPaypalSettings() {
	//     $return = array('success' => 0);

	//     $result = $this->db->get('paypalsettings');
	//     $row = $result->row();
	//     $error = $this->db->error();
	//     $errNo = $error['code'];

	//     if ($errNo == 0 && $result->num_rows() > 0) {
	//         $return = array('success' => 1, 'data' => $row);
	//     }

	//     return $return;
	// }

	function getEmailSettings()
	{
		$return = array('success' => 0);

		$result = $this->db->get('sitesettings');
		$row = $result->row();
		$error = $this->db->error();
		$errNo = $error['code'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			$return = array('success' => 1, 'data' => $row);
		}

		return $return;
	}

	function addpromoused($promo)
	{
		$sql = 'UPDATE  promo_limit l SET promo_used = promo_used + 1 where promo_id = (SELECT id from promo WHERE promo_code = "' . $promo . ' limit =1")';
		$result = $this->db->query($sql);
	}

	function checkPromo($insta_id='', $promo, $package_type = '')
	{

		$return = array('success' => 0, 'msg' => 'Promo not available!');

		$sql = 'SELECT `p`.`promo_code`, `p`.`percentage_discount` as discountPercent, p.promo_category, p.start_date , p.end_date, l.promo_limit 
                FROM promo p 
                LEFT JOIN promo_limit l on l.promo_id = p.id
                WHERE p.promo_code = "' . $promo . '" AND l.promo_used = 0';
		if ($package_type != '') {
			$sql .= ' AND (p.promo_category = "all") ';
		}

		$sql .= ' ORDER BY p.id DESC LIMIT 1';

		$result = $this->db->query($sql);
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			//promo aviable with user or not
			$return = array('success' => 1, 'data' => $result->row_array());
		}
		//$return['sql'] = $sql;
		return $return;
	}

	function getInvSender($where = array())
	{
		$return = array('success' => 0);
		if (empty($where)) {
			return $return;
		}

		$result = $this->db->get_where('invites', $where, 1);
		$sql = $this->db->last_query();
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			$res = $result->result_array();
			$return = array('success' => 1, 'data' => $res[0], 'sql' => $sql);
		}
		return $return;
	}

	function getServicesById($planId = '')
	{
		if ($planId == '') {
			return array('success' => 0, 'msg' => 'planId is empty');
		}
		$sql = "SELECT s.id,s.priceUnit, s.serviceType , r.url, p.service_id, s.packageTitle, s.packageQty, s.displayQty, s.other_type, s.packagePrice , d.package_description
                FROM `reseller_settings` r
                LEFT JOIN panel_services p ON p.panel_id = r.id
                LEFT JOIN igservices s ON s.serviceType = p.service_name
                LEFT JOIN ig_service_description d ON d.packageId = s.id
                                LEFT JOIN active_panel_service a ON s.serviceType = a.service_name
                WHERE s.id = " . $planId . " && a.panel_id = r.id ORDER BY s.packageQty ASC";
		$result = $this->db->query($sql);

		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {

			$return = array('success' => 1, 'data' => $result->result_array());
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}
		return $return;
	}

	function getPackageDescription($pckgId)
	{
		$return = array('success' => 0, 'msg' => 'Package id is missing.');
		if ($pckgId == '') {
			return $return;
		}

		$this->db->where("packageId", $pckgId);
		$result = $this->db->get('ig_service_description');

		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			$data = $result->result_array();
			$return = array('success' => 1, 'data' => $data);
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}

		return $return;
	}

	// function getServicesList($where = array()) {

	//     if (!empty($where)) {
	//         // $this->db->where($where); // OLD CODE
	//         $whereString = array_map(function($value, $key) {
	//             return $key . '="' . $value . '"';
	//         }, array_values($where), array_keys($where));
	//         $whereString = implode(' && ', $whereString);
	//         // $whereString = ' && '.$whereString;

	//         // if (strtolower($where['serviceType']) == 'followers' && !isset($where['packageQty'])) {
	//         //     $whereString .= ' || `serviceType` = "freefollowers"';
	//         // }

	//         // if (strtolower($where['serviceType']) == 'likes' && !isset($where['packageQty'])) {
	//         //     $whereString .= ' || `serviceType` = "freelikes"';
	//         // }
	//     }
	//     $sql = "SELECT s.id,s.priceUnit, s.serviceType, r.url, p.service_id, s.packageTitle, s.packageQty, s.displayQty, s.other_type,
	//                             s.packagePrice , d.package_description
	//             FROM `reseller_settings` r
	//             LEFT JOIN panel_services p ON p.panel_id = r.id
	//             LEFT JOIN igservices s ON s.serviceType = p.service_name
	//             LEFT JOIN ig_service_description d ON d.packageId = s.id
	//                             LEFT JOIN active_panel_service a ON s.serviceType = a.service_name
	//             WHERE a.panel_id = r.id && (" . $whereString . ")  ORDER BY s.packageQty ASC";

	//     $result = $this->db->query($sql);

	//     $error = $this->db->error();
	//     $errNo = $error['code'];
	//     $errMess = $error['message'];

	//     if ($errNo == 0 && $result->num_rows() > 0) {

	//         $return = array('success' => 1, 'data' => $result->result_array());
	//     } else {
	//         $return = array('success' => 0, 'msg' => $errMess);
	//     }
	//     return $return;
	// }


	// function getAppServices($where = array()) {

	//     if (!empty($where)) {
	//         // $this->db->where($where); // OLD CODE
	//         $whereString = array_map(function($value, $key) {
	//             return $key . '="' . $value . '"';
	//         }, array_values($where), array_keys($where));
	//         $whereString = implode(' && ', $whereString);
	//     }
	//     $sql = "s.packageTitle, s.id,s.priceUnit, s.serviceType, s.packageQty, s.displayQty, s.other_type,
	//                             s.packagePrice WHERE (" . $whereString . ") ORDER BY s.id ASC";
	//     $result = $this->db->query($sql);

	//     $error = $this->db->error();
	//     $errNo = $error['code'];
	//     $errMess = $error['message'];

	//     if ($errNo == 0 && $result->num_rows() > 0) {

	//         $return = array('success' => 1, 'data' => $result->result_array());
	//     } else {
	//         $return = array('success' => 0, 'msg' => $errMess);
	//     }
	//     return $return;
	// }

	function updateIfExists($table, $insertString, $updateString)
	{
		$sql = "INSERT INTO " . $table . " " . $insertString . "
                ON DUPLICATE KEY UPDATE " . $updateString;

		$this->db->query($sql);
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo) {
			$return = array('success' => 1, 'id' => $this->db->insert_id());
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}

		return $return;
	}

	// function saveUserData_old($table, $data) {
	//     $profileId = $data['profile_id'];
	//     $username = $data['user_name'];     $userEmail = $data['user_email'];
	//     $fullName = $data['full_name'];     $accessToken = $data['access_token'];
	//     $profileImage = $data['profile_image']; $userBio = $data['bio'];
	//     $website = $data['website'];      $isBusiness = $data['is_business'];
	//     $mediaCount = $data['media_count'];   $follows = $data['follows'];
	//     $followers = $data['followers'];

	//     $sql = "INSERT INTO ".$table."
	//             (`profile_id`, `user_name`, `user_email`, `full_name`, `access_token`, `profile_image`, `bio`,
	//             `website`, `is_business`, `media_count`, `follows`, `followers`, `password`)
	//         VALUES
	//             (".$profileId.", '".$username."', '".$userEmail."', '".$fullName."', '".$accessToken."', '".$profileImage."', '".$userBio."',
	//                 '".$website."', '".$isBusiness."', ".$mediaCount.", ".$follows.", ".$followers.")
	//         ON DUPLICATE KEY UPDATE
	//         profile_id=".$profileId.", user_name='".$username."', full_name='".$fullName."', access_token='".$accessToken."',
	//         profile_image='".$profileImage."', bio='".$userBio."', website='".$website."', is_business='".$isBusiness."', media_count='".$mediaCount."',
	//         follows='".$follows."', followers='".$followers."' ";

	//     return $this->db->query($sql);
	// }

	// function getPackageInfo($packageId) {
	//     $result = $this->db->get_where('igservices', array('id' => $packageId), 1);
	//     $error = $this->db->error();
	//     $errNo = $error['code'];
	//     $errMess = $error['message'];

	//     if ($errNo == 0 && $result->num_rows() > 0) {
	//         foreach ($result->result_array() as $row) {
	//             $data = $row;
	//         }
	//         $return = array('success' => 1, 'data' => $data);
	//     } else {
	//         $return = array('success' => 0, 'msg' => $errMess);
	//     }

	//     return $return;
	// }

	function getOrder($orderId, $where = array())
	{
		// $where = array('altrnt_id' => $orderId);
		$result = $this->db->get_where('mob_ig_orders', $where, 1);

		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			foreach ($result->result_array() as $row) {
				$data = $row;
			}
			$return = array('success' => 1, 'data' => $data);
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}

		return $return;
	}

	function getPnedingOrders($start, $end, $rel_id)
	{
		$threedaysleft = date("Y-m-d", strtotime("-3 day"));
		$where = array('order_status != ' => 'Completed', 'reseller_id' => $rel_id, 'date > ' => $threedaysleft . '%');

		$this->db->where($where);
		$this->db->order_by('id', 'DESC');
		$this->db->limit($start, $end);
		$result = $this->db->get('mob_ig_orders');

		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			foreach ($result->result_array() as $row) {
				$data[] = $row;
			}
			$return = array('success' => 1, 'data' => $data, 'last_query' => $this->db->last_query());
		} else {
			$return = array('success' => 0, 'msg' => $errMess, 'last_query' => $this->db->last_query());
		}

		return $return;
	}

	function getPnedingSubscriptions($rel_id)
	{
		$serivces = array('autolikes', 'autoviews');
		$status = array('Completed', 'Canceled');
		$where = array('reseller_id' => $rel_id);

		$this->db->where($where);
		$this->db->where_in('service_type', $serivces);
		$this->db->where_not_in('order_status', $status);
		$this->db->order_by('id', 'DESC');
		$result = $this->db->get('mob_ig_orders');

		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			foreach ($result->result_array() as $row) {
				$data[] = $row;
			}
			$return = array('success' => 1, 'data' => $data, 'last_query' => $this->db->last_query());
		} else {
			$return = array('success' => 0, 'msg' => $errMess, 'last_query' => $this->db->last_query());
		}

		return $return;
	}

	function add_user($data)
	{
		$invData = array('rsvr_user_id' => $_SESSION['user_name'], 'status' => 0, 'used' => 0);

		$invResult = $this->Mob_admin->getInvitePackage($invData);

		if ($invResult['success'] == 1) {
			$status = 1;
			$invitData = $invResult['data'][0];
			$_SESSION['refData'] = $invitData;
			$this->updateRefStatus($invitData['id'], $status);
		}

		return $this->db->replace('traffic', $data);
	}

	function updateRefStatus($userId, $status = 0)
	{


		if ($status == 1) {
			$this->db->where('status', 0);
		} else if ($status == 2) {
			$this->db->where('status', 1);
		}

		$updateData = array(
			'status' => $status
		);
		$this->db->where('id', $userId);

		$resData = $this->db->update('invites', $updateData);
	}

	function insertOrderInfo($table, $data = array())
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	function insertRow($table, $data = array())
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	function insertCustomOrder($table, $data = array())
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
		//        return $this->db->last_query();
	}

	function updateOrderInfo($table, $orderInsId, $data = array())
	{

		$this->db->where('order_id', $orderInsId);
		$update = $this->db->update($table, $data);
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0) {
			$return = array('success' => 1, 'data' => $update);
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}
		return $return;
	}

	public function updateOrderItemInfo($table, $where, $data)
	{
		$this->db->where($where);
		$update = $this->db->update($table, $data);
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];
		if ($errNo == 0) {
			$return = array('success' => 1, 'data' => $update);
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}
		return $return;
	}

	function getFreeRow($user_name, $profile_id)
	{

		if (intval($profile_id) > 0) {
			$this->db->where("user_id", $user_name)->or_where("profile_id", $profile_id);
		} else {
			$this->db->where("user_id", $user_name);
		}

		$result = $this->db->get('free_service');

		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			$data = $result->result_array();
			$return = array('success' => 1, 'data' => $data);
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}

		return $return;
	}

	function getOrderByOrderId($order_id)
	{

		$this->db->where("order_id", $order_id);
		$result = $this->db->get('mob_ig_orders');
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];
		if ($errNo == 0 && $result->num_rows() > 0) {
			$data = $result->result_array();
			$return = array('success' => 1, 'data' => $data[0]);
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}

		return $return;
	}
	function getCartOrderByOrderId($order_id)
	{
		// $this->db->where(array('order_id' => $order_id, 'stripe_transaction_id !=' => NULL));
		$this->db->where(array('order_id' => $order_id));
		$result = $this->db->get('mob_cart_order');
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];
		if ($errNo == 0 && $result->num_rows() > 0) {
			$data = $result->result_array();
			$return = array('success' => 1, 'data' => $data[0]);
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}
		return $return;
	}
	// cart order items joined with selected posts
	function getOrderItemByOrderId($order_id)
	{
		$this->db->select('cart_order_items.id as item_id, cart_order_items.api_order_id, cart_order_items.user_name, cart_order_items.service_id, cart_order_items.service_type
        ,cart_order_items.package_id, cart_order_items.package_quantity, cart_order_selected_post.quantity, 
        cart_order_selected_post.post_id, cart_order_selected_post.comments,cart_order_selected_post.api_order_id as api_order_item_id, cart_order_selected_post.id as cart_order_selected_id');
		$this->db->join('cart_order_selected_post', 'cart_order_selected_post.order_item_id = cart_order_items.id', 'left');
		$this->db->where("cart_order_items.order_id", $order_id);
		$result = $this->db->get('cart_order_items');
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];
		if ($errNo == 0 && $result->num_rows() > 0) {
			$data = $result->result_array();
			$return = array('success' => 1, 'data' => $data);
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}
		return $return;
	}
	// cart order items with free services
	function getOrderItemFreeServicesByOrderId($order_id)
	{
		// coi => cart_order_item
		// cifs => cart_free_services
		$this->db->select('coi.id as item_id, coi.api_order_id, cifs.id as cart_order_selected_id, cifs.free_service_qty as package_quantity, 
        cifs.free_service_link as link,cifs.free_service_link as user_name, cifs.free_service_id as service_id, cifs.api_order_id as api_order_item_id');
		$this->db->join('cart_free_services as cifs', 'cifs.order_item_id = coi.id');
		$this->db->where("coi.order_id", $order_id);
		$result = $this->db->get('cart_order_items as coi');
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];
		if ($errNo == 0 && $result->num_rows() > 0) {
			$data = $result->result_array();
			$return = array('success' => 1, 'data' => $data);
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}
		return $return;
	}
	function getPosts($order_id)
	{

		$this->db->where("order_id", $order_id);
		$this->db->select('selected_posts');
		$result = $this->db->get('mob_ig_orders');

		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			$data = $result->result_array();
			$return = array('success' => 1, 'data' => $data[0]);
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}

		return $return;
	}

	/* Awarded to user by
	  sending invitation to others */

	function getInvitePackage($where = array())
	{
		if (empty($where)) {
			return array('success' => 0, 'msg' => 'wrong data');
		}
		// $where = array('sender_user_id' => $user_name, 'status' => $status, 'used' => 0);
		$result = $this->db->get_where('invites', $where);

		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			$data = $result->result_array();
			$return = array('success' => 1, 'data' => $data);
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}

		return $return;
	}

	function userInvStatus($email)
	{
		$result = $this->db->get_where('invites', array('email' => $email), 1);
		$return = array();
		$error = $this->db->error();
		if ($error['code'] > 0) {
			$errNo = $error['code'];
			$errMess = $error['message'];
			return array('success' => 0, 'msg' => $errMess);
		}

		if ($result->num_rows() > 0) {
			// $data = $result->result_array();
			$return = array('success' => 1, 'recordFound' => 1, 'message' => 'Already invited.', 'data' => $result);
		} else {
			$return = array('success' => 1, 'recordFound' => 0, 'message' => 'Error! No record found.');
		}

		return $return;
	}

	function createUserInv($params)
	{
		// print_r($data); exit;
		$data['email'] = $params['friend_email'];
		$data['sender_email'] = $params['user_email'];
		$data['inv_code'] = $params['code'];
		$table = 'invites';

		$result = $this->db->insert($table, $data);

		$return = array();
		$error = $this->db->error();
		if ($error['code'] > 0) {
			$errNo = $error['code'];
			$errMess = $error['message'];
			return array('success' => 0, 'msg' => $errMess);
		}

		$return = array('success' => 1, 'data' => $result);

		return $return;
	}

	function getResult($table, $columns, $where = array())
	{
		$this->db->select($columns);
		$this->db->where($where);
		$this->db->where($where);
		$result = $this->db->get($table);

		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			$data = $result->result_array();
			$return = array('success' => 1, 'data' => $data);   //, 'last_query' => $this->db->last_query()
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}

		return $return;
	}

	function getRow($table, $columns, $where = array())
	{
		$this->db->select($columns);
		$this->db->where($where);
		$result = $this->db->get($table);
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			$data = $result->row_array();
			$return = array('success' => 1, 'data' => $data);
		} else {
			$return = array('success' => 0, 'msg' => $errMess);
		}

		return $return;
	}

	function saveReferalInfo($data = array())
	{
		$code = isset($data['code']) ? $data['code'] : '';
		$rcvrInstaId = isset($data['rcvrInstaId']) ? $data['rcvrInstaId'] : '';
		$status = isset($data['status']) ? $data['status'] : '';

		if ($code == '') {
			return array('success' => 0);
		}

		$where = array('link_code' => $code);
		$result = $this->getInvSender($where);

		if ($result['success'] == 1) {
			$referalId = $result['data']['id'];
		}
		$table = "invite_refers";
		$data = array(
			'referal_id' => $referalId,
			'receiver_insta_id' => $rcvrInstaId,
			'status' => $status
		);

		$dataInserted = $this->db->insert($table, $data);

		if ($dataInserted) {
			$insertStatus = array('success' => 1);
		}
		return $insertStatus;
	}

	public function getOrderRow($rowId = '')
	{
		$return = array('success' => 0);
		$sql = "SELECT * FROM `mob_ig_orders` WHERE (order_id IS NULL OR order_id = '') AND "
			. "(altrnt_id IS NULL OR altrnt_id = '' ) AND user_email != '' AND "
			. "service_type NOT IN('freefollowers', 'freelikes') AND "
			. "user_email NOT IN ('hashcode512@gmail.com', 'numanbasit@gmail.com', 'mn.ah66@gmail.com')";
		if ($rowId != '') {
			$sql .= "AND id = " . $rowId;
		}

		$result = $this->db->query($sql);

		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			$return = array('success' => 1, 'data' => $result->result_array());
		} else {
			$return = array('success' => 0, 'message' => $errMess);
		}
		return $return;
	}

	public function getNewPrices($serviceType, $prcnt)
	{
		$percentage = intval($prcnt) / 100;
		$sql = "SELECT id, packagePrice, (packagePrice + (packagePrice * " . $percentage . ")) as new_price, packageQty, serviceType "
			. "FROM `igservices` "
			. "WHERE serviceType = '" . $serviceType . "' ORDER BY packageQty ASC";

		$result = $this->db->query($sql);

		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			$return = array('success' => 1, 'data' => $result->result_array());
		} else {
			$return = array('success' => 0, 'message' => $errMess);
		}
		return $return;
	}

	public function getInvRecord($sender, $receiver)
	{
		$sql = "SELECT p.* FROM invites p WHERE "
			. "sender_user_id = (SELECT sender_user_id FROM invites WHERE sender_user_id = '" . $sender . "' ORDER BY id DESC LIMIT 1) OR "
			. "rsvr_user_id = (SELECT rsvr_user_id FROM invites WHERE rsvr_user_id = '" . $receiver . "' ORDER BY id DESC LIMIT 1) "
			. "GROUP BY sender_user_id";

		$result = $this->db->query($sql);

		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0) {
			$data = ($result->num_rows() > 0) ? $result->result_array() : array();
			$return = array('success' => 1, 'data' => $data);
		} else {
			$return = array('success' => 0, 'message' => $errMess);
		}
		return $return;
	}

	public function get_deals($deal_name = '')
	{
		$sql = "SELECT b.deal_id, a.deal_name, a.deal_short_name, a.deal_description, a.start_date, a.expiry_date, b.product_id, c.serviceType, c.packageTitle, 
                c.packageQty, c.priceUnit, c.packagePrice, b.discount_prcnt, FORMAT((c.packagePrice - (c.packagePrice * (b.discount_prcnt / 100))), '2') as discounted_price, ap.panel_id,
                (SELECT service_id FROM panel_services WHERE panel_id = ap.panel_id AND service_name = c.serviceType) as service_id                
                FROM mob_deals a
                left join deal_products_detail b on a.id = b.deal_id
                left join igservices c on c.id = b.product_id   
                LEFT JOIN active_panel_service ap ON ap.service_name = c.serviceType                
                WHERE (CURRENT_DATE BETWEEN a.start_date AND a.expiry_date)";
		if ($deal_name != '') {
			$sql .= " AND a.deal_short_name = '" . $deal_name . "'";
		}
		$sql .= " ORDER BY a.created_date desc";

		$result = $this->db->query($sql);
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0) {
			$data = ($result->num_rows() > 0) ? $result->result_array() : array();
			$return = array('success' => 1, 'data' => $data);
		} else {
			$return = array('success' => 0, 'message' => $errMess);
		}
		return $return;
	}

	public function get_reseller_services($deal_name = '')
	{
		$result = $this->db->query("SELECT * FROM `panel_services` WHERE panel_id IN (1,3) ");
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0) {
			$data = ($result->num_rows() > 0) ? $result->result_array() : array();
			$return = array('success' => 1, 'data' => $data);
		} else {
			$return = array('success' => 0, 'message' => $errMess);
		}
		return $return;
	}

	public function run_sql($sql)
	{
		$result = $this->db->query($sql);
		$error = $this->db->error();
		$errNo = $error['code'];
		$errMess = $error['message'];

		if ($errNo == 0) {
			$data = ($result->num_rows() > 0) ? $result->result_array() : array();
			$return = array('success' => 1, 'data' => $data);
		} else {
			$return = array('success' => 0, 'message' => $errMess);
		}
		return $return;
	}

	public function get_single_deal($deal_name = '')
	{
		$single_deal = array();
		$deals = $this->get_deals($deal_name);
		if ($deals['success'] == 1) {
			$single_deal = $deals['data'][0];
		}
		return $single_deal;
	}

	public function getQuantityByType($stype = '')
	{
		$return = array('success' => 0);
		$this->db->where(array('serviceType' => $stype));
		$this->db->select('id, packageQty, packagePrice');
		$result = $this->db->get('igservices');
		$error = $this->db->error();
		$errNo = $error['code'];
		if ($errNo == 0 && $result->num_rows() > 0) {
			$return = array('success' => 1, 'data' => $result->result_array());
		}
		return $return;
	}

	public function getPackageById($id = '')
	{
		$return = array('success' => 0);
		$this->db->where(array('id' => $id));
		$result = $this->db->get('igservices');
		$error = $this->db->error();
		$errNo = $error['code'];
		if ($errNo == 0 && $result->num_rows() > 0) {
			$return = array('success' => 1, 'data' => $result->result_array());
		}
		return $return;
	}
}
