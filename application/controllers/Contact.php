<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
         $this->load->library('session');

    }

	public function index()
	{
		
		$this->load->library('form_validation');
		 $this->load->helper('Security');
        $this->form_validation->set_rules('name', 'Username', 'xss_clean|trim|required');
        $this->form_validation->set_rules('email', 'Email', 'xss_clean|trim|valid_email|required');
        $this->form_validation->set_rules('message', 'Message check', 'xss_clean|strip_tags|required');
        if($this->form_validation->run())
		  {
		   	$this->load->model('genral_model');
		   	$data['name'] = $_POST['name'];
            $data['email'] = $_POST['email'];
            $data['message'] = $_POST['message'];
		   	$sendData = $this->genral_model->store('contact_us',$data);
		   	$array = array(
		    'success' => '<div class="alert alert-success">Thank you for Contact Us</div>'
		   );

		  }
		  else
		  {
			   $array = array(
			    'error'   => true,
			    'name_error' => form_error('name'),
			    'email_error' => form_error('email'),
			    'message_error' => form_error('message')
			   );
		  }

  			echo json_encode($array);
	}
}
