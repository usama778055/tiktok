<?php
defined("BASEPATH") or exit("Direct access denied...");

class Users extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->user = $this->session->userdata('logged_in');
	}

	function selectjoin() {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('posts','posts.user_id = users.id');
		$this->db->join('categories','ON posts.category_id = categories.id ','left');
		$query = $this->db->get();
		return $query->result();
	}

	function selectlimitedjoin() {
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('posts','posts.user_id = users.id');
		$this->db->join('categories','ON posts.category_id = categories.id ','left');
		$this->db->limit(3);
		$query = $this->db->get();

		return $query->result();
	}


	public function GetNextBlogs($slug){

		$sql = "SELECT slug FROM posts WHERE id > posts.id ORDER BY id ASC LIMIT 1 as next_slug FROM posts JOIN users ON posts.user_id = users.id left join categories posts.category_id = categories.id WHERE slug = '".$slug."'";
		
		return $this->db->query($sql)->result();
	}

	
	public function getByColumn($value)
	{
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->join('users', 'posts.user_id = users.id');
		$this->db->join('categories','ON posts.category_id = categories.id ','left');
		
		$this->db->where($value);
		
		return $this->db->get()->result();
	}

	public function getBlogById($table,$colum, $value)
	{
		$sql = "SELECT u.name,p.title, p.slug, p.body, p.created_at, p.updated_at, p.post_thumbnail, c.cat_name,(SELECT slug FROM posts WHERE id > p.id ORDER BY id ASC LIMIT 1)as next_slug, (SELECT slug FROM posts WHERE id < p.id ORDER BY id DESC LIMIT 1) as prev_slug FROM posts p JOIN users u ON p.user_id = u.id left join categories c ON p.category_id = c.id WHERE ".$colum." = '".$value."'";
		
		return $this->db->query($sql)->result();
	}

	public function selectlimitjoin($slug) {
		$this->db->select('*');
		$this->db->from('posts');
		$query = $this->db->join('users','ON posts.user_id = users.id ')->join('categories','ON posts.category_id = categories.id ','left');
		$this->db->where("posts.slug != '{$slug}' AND posts.feature = 1");
		$this->db->limit(3);
		
		return $this->db->get()->result();
	}

	public function feature_blog() {
		$this->db->select('*');
		$this->db->from('posts');
		$query = $this->db->join('users','ON posts.user_id = users.id ')->join('categories','ON posts.category_id = categories.id ','left');
		$this->db->where("posts.feature = 1");
		$this->db->limit(4);
		
		return $this->db->get()->result();
	}

	public function feature_packagebuy() {
		$this->db->select('*');
		$this->db->from('posts');
		$query = $this->db->join('users','ON posts.user_id = users.id ')->join('categories','ON posts.category_id = categories.id ','left');
		$this->db->where("posts.feature = 1");
		$this->db->limit(3);
		
		return $this->db->get()->result();
	}

	public function get_id($table, $value)
	{
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->where($value);
		
		return $this->db->get()->result();
	}

	public function nextdata($table, $value)
	{
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->where('posts.id >' , $value);
		$this->db->order_by('posts.id', 'asc')->limit(1);
		$this->db->join('users', 'ON posts.user_id = users.id','left');
		
		return $this->db->get()->result();
	}
	public function get_stripe_data() {
		$return = array('success' => 0);
		$this->db->select('id, companyName, currency, stripePublishableKey, stripeSecretKey, sandbox');
		$this->db->where('active',1);
		$result = $this->db->get('stripesetting');
		$row = $result->row();
		$error = $this->db->error();
		$errNo = $error['code'];

		if ($errNo == 0 && $result->num_rows() > 0) {

			$return = array('success' => 1, 'data' => $row);
		}
		return $return;
	}
	public function getStripeCustomer($email) {
		$return = array('success' => 0);
		$this->db->where('user_email', $email);
		$this->db->select('customer_id');
		$result = $this->db->get('stripe_transaction_data');
		$row = $result->row();
		$error = $this->db->error();
		$errNo = $error['code'];

		if ($errNo == 0 && $result->num_rows() > 0) {
			$return = array('success' => 1, 'customer_id' => $row->customer_id);
		}
		return $return;
	}
	public function insertStripeData($data) {
		$this->db->insert('stripe_transaction_data', $data);
		$insertId = $this->db->insert_id();
		$error = $this->db->error();
		if ($error['code'] == 0) {
			$return = array('success' => 1, 'data' => $insertId);
		} else {
			$return['error'] = $error['message'];
		}

		return $return;
	}

}
