<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog extends CI_Controller
{

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
    }
    /*{
    "place_id" :"0509be86e76bc794104d74113eb23e3a"
}*/

public function index(){


    $data["latest"] = $this->genral_model->get_authors(4, 0);
    $data["featured"] = $this->users->feature_blog();
    $data["alldata"] = $this->users->selectjoin(); 
        /*$pageall=count($alldata);

        


        $config = array();
        $config["uri_segment"] = 2;
        $config["base_url"] = base_url('blogs');
        $config["total_rows"] = $pageall;
        $config["per_page"] = 7;
        
        $config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination pagination-sm uk-list uk-flex ul_justify">';        
        $config['full_tag_close'] = '</ul></nav>';        
        $config['first_link'] = 'First';        
        $config['last_link'] = 'Last';        
        $config['first_tag_open'] = '<li class=""><span class="uk-button uk-button-default">';        
        $config['first_tag_close'] = '</span></li>';        
        $config['prev_link'] = '&laquo';        
        $config['prev_tag_open'] = '<li class=""><span class="uk-button uk-button-default">';        
        $config['prev_tag_close'] = '</span></li>';        
        $config['next_link'] = '&raquo';        
        $config['next_tag_open'] = '<li class=""><span class="uk-button uk-button-default">';        
        $config['next_tag_close'] = '</span></li>';        
        $config['last_tag_open'] = '<li class=""><span class="uk-button uk-button-default">';        
        $config['last_tag_close'] = '</span></li>';        
        $config['cur_tag_open'] = '<li class="active "><a class="uk-text-muted uk-button uk-button-default" href="javascript:void(0);">';        
        $config['cur_tag_close'] = '</a></li>';        
        $config['num_tag_open'] = '<li class=""><span class="uk-button uk-button-default">';        
        $config['num_tag_close'] = '</span></li>'; 
        
        $config['use_page_numbers'] = TRUE;
        $config['first_url'] = '1';        
        
        $tot_pages = ceil($pageall / $config["per_page"]);

        if($this->uri->segment(2) < 1 || $this->uri->segment(2) > $tot_pages)
            return redirect(base_url('blogs/1'));


        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        
        
        $offset = ($page == 0  ? 0 : ($page - 1) * $config["per_page"]);

        $data["links"] = $this->pagination->create_links();

        $data["result"] = $this->genral_model->get_authors($config["per_page"], $offset);


        $data['start'] = ($page == 0 ? 0 : (($page - 1) * $config["per_page"] + 1));*/
        $this->load->view('blogs/blog',$data);
    }
    
    public function slugData($slug){
        $data['slug'] = $slug;

        $getData['data'] = $this->users->getBlogById('posts',"p.slug",$slug);
        $getData['alldata'] = $this->users->selectlimitjoin($slug);
        
        $this->load->view('blogs/single_blog',$getData);
    }

    public function categoryData($name){
        $data['cat_name'] = $name;
        $getData = $this->users->getByColumn($data);
        $pageall=count($getData);
        $config = array();
        $config["uri_segment"] = 3;
        $config["base_url"] = base_url('category/'.$name);
        $config["total_rows"] = $pageall;
        $config["per_page"] = 7;
        $config['full_tag_open'] = '<p>';
        $config['full_tag_close'] = '</p>';
       
        $config['first_link'] = 'First';        
               
        $config['first_tag_open'] = '<div class= "" >';        
        $config['first_tag_close'] = '</div>';
        $config['last_link'] = 'Last'; 
        $config['last_tag_open'] = '<div>';
        $config['last_tag_close'] = '</div>';
        $config['next_link'] = '&gt;';
        $config['next_tag_open'] = '<div>';
        $config['next_tag_close'] = '</div>';
        $config['prev_link'] = '&lt;';
        $config['prev_tag_open'] = '<div>';
        $config['prev_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<b>';
        $config['cur_tag_close'] = '</b>';
        $config['num_tag_open'] = '<div>';
        $config['num_tag_close'] = '</div>';        
                
        $config['cur_tag_open'] = '<div class="uk-active"><a class="uk-text-muted uk-button-default" href="javascript:void(0);">';        
        $config['cur_tag_close'] = '</a></div>';        
         
        
        $config['use_page_numbers'] = TRUE;
        $config['first_url'] = '1';        
        
        $tot_pages = ceil($pageall / $config["per_page"]);

        if($this->uri->segment(3) < 1 || $this->uri->segment(3) > $tot_pages)
            return redirect(base_url('category/'.$name.'/1'));


        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;
        
        
        $offset = ($page == 0  ? 0 : ($page - 1) * $config["per_page"]);

        $data["links"] = $this->pagination->create_links();

        $data["result"] = $this->genral_model->get_categories_authors($config["per_page"], $offset,$name);


        $data['start'] = ($page == 0 ? 0 : (($page - 1) * $config["per_page"] + 1));
        $this->load->view('blogs/categories_page',$data);
        /*print_r($data["result"]);*//**/

        
    }

    public function previosData(){
        $id = $_POST['id'];
        echo $id;

    }


}
