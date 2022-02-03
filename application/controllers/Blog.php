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


    $data["latest"] = $this->genral_model->get_authors();
    $data["featured"] = $this->users->feature_blog();
    $data["alldata"] = $this->genral_model->minimum_data(); 

    $this->load->view('blogs/blog',$data);
    }

    public function more_any_blogs(){
        $slug = $this->input->post('slug');
        $getData['alldata'] = $this->genral_model->limited_data($slug);
        $this->load->view('blogs/dropdown_blogs', $getData);
    }
    
    public function slugData($slug){

        $getData['data'] = $this->users->getBlogById('posts',"p.slug",$slug);
        
        if(is_numeric($this->uri->segment(2)))
            return redirect('blogs');

        else if(!$getData['data'])
            show_404();

        $data['slug'] = $slug;
        $getData['alldata'] = $this->users->selectlimitjoin($slug);
        $this->load->view('blogs/single_blog',$getData);
    }

    public function categoryData($name){
        $data['cat_name'] = $name;
        $getData = $this->users->getByColumn($data);
        if(empty($getData)){
            show_404();
        }
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

        if(empty($this->uri->segment(3)) || $this->uri->segment(3) < 1 || $this->uri->segment(3) > $tot_pages)
            return redirect(base_url('category/'.$name.'/1'));


        $this->pagination->initialize($config);
        $page = (!empty($this->uri->segment(3))) ? $this->uri->segment(3) : 1;
        
        
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
