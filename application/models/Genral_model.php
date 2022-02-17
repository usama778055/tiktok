<?php
defined("BASEPATH") or exit("Direct access denied...");

class Genral_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function store($table, $data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function getByColumn($table, $name, $value)
	{
		$this->db->where($name, $value);
		return $this->db->get($table)->result();
	}
	
	public function getByIdd($table, $id)
	{
		$this->db->where('id', $id);
		return $this->db->get($table)->row();
	}

	public function getById($table, $id)
	{
		$this->db->where('id', $id);
		return $this->db->affected_rows();
	}

	public function getByemail($table, $email)
	{
		$this->db->where($email);
		return $this->db->get($table)->row();
	}
	
	public function selectDataFromAny($Any,$table,$where){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($Any,$where);
		$query = $this->db->get();
		if($query->num_rows() == 1){
			return $query->result_array();
		}
	}

	public function select_all_data($serviceType,$val,$table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("{$serviceType} = '{$val}'");
		return $this->db->get()->result();
	}

	public function getByIdAndValue($table, $id, $colum)
	{
		$this->db->where($colum, $id);
		$this->db->order_by("id", "desc");
		return $this->db->get($table)->row();
	}
	public function update($table, $where = NULL, $data)
	{
		if (!empty($where)) {
			$this->db->where($where);
		}
		$query = $this->db->update($table, $data);
		if ($query) {
			return $this->db->affected_rows();
		}
	}

	public function update_data($table, $where, $data)
	{
		if (!empty($where)) {
			$this->db->where($where);
		}
		$query = $this->db->update($table, $data);
		if ($query) {
			return $this->db->affected_rows();
		}
	}
	
	public function selectData($table){
		$this->db->select('*');
		$this->db->from($table);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function select_service($table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join('categories', "ON {$table}.category_id = categories.id",'left');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function fetch_departments($limit, $start) {
		$this->db->limit($limit, $start);
		$query = $this->db->get("posts");
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function get_authors() {
		$this->db->select('posts.*, users.name, categories.*');
		$this->db->from('posts');
		$this->db->join('users', 'ON posts.user_id = users.id','left');
		$this->db->join('categories', 'ON posts.category_id = categories.id','left');
		$this->db->order_by('posts.id',"desc");
		$this->db->limit(4);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function minimum_data() {
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->join('users', 'ON posts.user_id = users.id','left');
		$this->db->join('categories', 'ON posts.category_id = categories.id','left');
		$this->db->limit(3);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	public function limited_data($slug) {
		$que = "SELECT * FROM posts left join users ON posts.user_id = users.id left join categories ON posts.category_id = categories.id WHERE posts.id > (SELECT posts.id from posts where posts.slug = '{$slug}') ORDER BY posts.id ASC LIMIT 3";
		return $this->db->query($que)->result();
	}

	public function get_categories_authors($limit, $start,$value) {
		$this->db->select('*');
		$this->db->from('posts');
		$this->db->join('users', 'ON posts.user_id = users.id','left');
		$this->db->join('categories', 'ON posts.category_id = categories.id','left');
		$this->db->where('categories.name =',$value);
		$this->db->limit($limit, $start);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

	function get_records($table1,$table2,$user_id,$any, $where)
	{
		$this->db->select('*');
		$this->db->from($table1);
		$this->db->join($table2, "ON ".$table2.".".$any." = ".$table1.".".$user_id);

		$this->db->where($table2.".".$any. " = " , $where);
		
		return $this->db->get()->result();
	}

	function get_packagerecords($table1,$table2,$user_id,$any, $where)
	{
		$this->db->select('*');
		$this->db->from($table1);
		$this->db->join($table2, "ON ".$table2.".id = ".$table1.".".$user_id);

		$this->db->where($table2.".".$any. " = " , $where);
		$this->db->limit(4);
		return $this->db->get()->result();
	}

	function get_one_records($table,$tab2,$u_id, $where)
	{
		$this->db->select('*');
		$this->db->from($table);
		$this->db->join($tab2, "ON {$table}.id = {$tab2}.{$u_id}",'left');
		$this->db->where($table.".id = " , $where);
		$this->db->limit(1);
		return $this->db->get()->row();
	}

	function get_stype_qun_data($serviceType,$val1,$packageQty ,$val2,$table){
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where("{$serviceType} = '{$val1}' and {$packageQty} = '{$val2}'");
		return $this->db->get()->result();
	}

	function deleteRow($table, $name, $value) {
		$this->db->where($name, $value);
		$this->db->delete($table);
		return $this->db->affected_rows();
	}

	public function get_records_order_by($table,$colum,$orderBY)
	{
		$this->db->select("$table.* , categories.name as name");
		$this->db->join("categories", $table . ".category_id = categories.id");
		$this->db->order_by("$table.$colum", $orderBY);
		$query = $this->db->get($table);
		return $query->result();
	}


}
