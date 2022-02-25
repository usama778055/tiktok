<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
	public $postData = array();
	public function __construct()
    {
        parent::__construct();
        /*$this->is_logged();*/
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('users');
        $this->load->model('genral_model');
        $this->load->library('pagination');
        $this->load->library('image_lib');
		if ($this->input->post('action', True) != false) {
			$this->cleanPostData();
			$this->request();
		}
    }

	public function request()
	{
		$post = $this->postData;
		$act  = $post['action'];
		if (method_exists($this, $act)) {
			$this->$act($post);
		} else {
			$this->response(400, "Invalid request.");
		}
	}
    public function index(){
        $data['sub_categories'] = $this->genral_model->selectData('sub_categories');
        $data['data'] = $this->genral_model->selectData('reviews');
        $data['feature_data'] = $this->genral_model->selectData('features');
        $data['service_data'] = $this->genral_model->select_service('cat_service');

        $this->load->view('home/home',$data);
    }
    
    public function faq(){
        $data['data'] = $this->genral_model->selectData('faqs');
        $this->load->view('faq/faq_view',$data);
    }

    public function package($slug){
        $packages = $this->genral_model->selectDataFromAny('slug' , 'sub_categories',$slug);
        if(empty($packages)){
            show_404();
        }
        $id = $packages[0]['id'];
        $cate_id = $packages[0]['cate_id'];
        $service_id = $packages[0]['service_id'];
        $description_id = $packages[0]['description_id'];
        $record_packages['alldata'] = $this->genral_model->get_records('sub_categories','igservices','service_id','service_id' ,$service_id);

        if(empty($record_packages['alldata'])){
            show_404();
        }
        foreach($record_packages as $value){
            $single_id = $value[0]->id;
        }

        $record_packages['single_data'] = $this->genral_model->get_records('ig_service_description','igservices','packageId','id' ,$single_id);
        $record_packages['category'] = $packages;
        $record_packages["featured"] = $this->genral_model->get_packagerecords('ig_service_description','igservices','packageId','favourite' ,1);
        
        $this->load->view('package/package',$record_packages);
    }

    public function package_getdata()
    { 
        $packages['single_data'] = $this->genral_model->get_one_records('igservices' , 'ig_service_description','packageId',$_POST['id']);
        $this->load->view('package/package_partial_view',$packages);
    }

    public function purchase_package($quantity, $stype)
    {
        // echo "<pre>";print_r($this->session->all_userdata());exit;
    	/*print_r($stype);*/
        $record_packages['user_data'] = $this->genral_model->get_stype_qun_data('serviceType',$stype,'packageQty' ,$quantity,'igservices');
        if(empty($record_packages['user_data'])){
            show_404();
        }
        $record_packages['alldata'] = $this->genral_model->select_all_data('serviceType',$stype,'igservices');
        $record_packages["featured"] = $this->genral_model->get_packagerecords('ig_service_description','igservices','packageId','displayQty' ,1);

        $this->session->set_userdata('package_detail', $record_packages['user_data'][0]);
        $this->load->view('package/purchase_package',$record_packages);
    }

    public function get_tiktok_user($post)
    {
    	//echo print_r($this->input->post('user_name'));exit;
		$html="";
		$this->load->library('findinstauser');
		if(isset($_SESSION['user_name']) && ($this->input->post('user_name')==$_SESSION['user_name']))
		{
			$data["user"] = $_SESSION['user_api_info'];
			$html = $this->load->view('package/api_images_partial_view', $data, TRUE);
		}
		else{
			//echo "noooo";exit;
			$user_data = $this->findinstauser->findUser($post);
			if ($user_data['success'] == 1) {
				$userInfo=$this->session->set_userdata('user_api_info',$user_data['data']);
				$data["user"] = $user_data['data'];
				$html = $this->load->view('package/api_images_partial_view', $data, TRUE);
			}
		}
		/*$user_data = $this->findinstauser->findUser($post);
		if ($user_data['success'] == 1) {
			$userInfo=$this->session->set_userdata('user_api_info',$user_data['data']);
			$data["user"] = $user_data['data'];
			$html = $this->load->view('package/api_images_partial_view', $data, TRUE);
		}*/
		$resp = array(
			"html" => $html,
			"data" => $data,
			"success" => true,
			"message" => ""
		);
		if (empty($html)) {
			$resp["success"] = false;
		}
		exit(json_encode($resp));


    }

    public function find_tiktok_user()
    {
        $post = $this->postData;
        $act  = $post['action'];
        if (method_exists($this, $act)) {
            $this->$act($post);
        } else {
            $this->response(400, "Invalid request.");
        }
    }

    private function find_user($post)
    {
        $this->load->library('findinstauser');
        $user_data = $this->findinstauser->findUser($post);
        $user_data = (object) $user_data;
        if ($user_data->success == 1) {
            $user_data = (object) $user_data->data;
            $user = (object) $user_data->user;
            $posts = $user_data->user_posts;
            $data["user"] = $user;
            $data["posts"] = $posts;
            $html = $this->load->view('templates/app_profile', $data, TRUE);
        }
        $resp = array(
            "html" => $html,
            "data" => $data,
            "success" => true,
            "message" => ""
        );
        if (empty($html)) {
            $resp["success"] = false;
        }
        exit(json_encode($resp));
    }

    public function comment_section(){
        $comment_section['comments'] = $_POST;

        $this->load->view('package/comment_section',$comment_section);

    }

    public function aboutus(){            
        $this->validation();
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('aboutUs/about_us');
        }
        else{
            $data['name'] = $_POST['name'];
            $data['email'] = $_POST['email'];
            $data['message'] = $_POST['message'];
            $sendData = $this->genral_model->store('contact_us',$data);
            redirect(base_url('about-us#contact_sec'));
        }
    }

    public function apply_coppen(){
        $record = $this->genral_model->getByColumn('apply_for_coppen','email',$_POST['email']);
        
        if(empty($record)){
            $email['email'] = $_POST['email'];
            $sendEmail = $this->genral_model->store('apply_for_coppen',$email);
            echo 'true';
        }
        else{
            echo 'false';
        }
    }

    public function subcribe_for_new(){
        $record = $this->genral_model->getByColumn('subcribe_for_news','email',$_POST['email']);
        
        if(empty($record)){
            $email['email'] = $_POST['email'];
            $sendEmail = $this->genral_model->store('subcribe_for_news',$email);
            echo 'true';
        }
        else{
            echo 'false';
        }
    }

    public function validation()
    {    
        $this->load->helper('Security');
        $this->form_validation->set_rules('name', 'Username', 'xss_clean|trim|required');
        $this->form_validation->set_rules('email', 'Email', 'xss_clean|trim|required');
        $this->form_validation->set_rules('message', 'Massage', 'xss_clean|strip_tags|required');
    }
	private function cleanPostData()
	{
		if ($this->input->post('action', True) != false) {
			foreach ($this->input->post() as $key => $post) {
				$this->postData[$key] = $this->input->post($key, True);
			}
		}
	}






}
