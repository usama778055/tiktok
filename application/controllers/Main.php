<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
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
        /*$data["latest"] = $this->genral_model->get_authors(4, 0);
        
        $this->load->view('blogs/blog',$data);*/
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
         $record_packages["featured"] = $this->genral_model->get_packagerecords('ig_service_description','igservices','packageId','displayQty' ,1);
         
        //         echo "<Pre>";
        // print_r($record_packages);
        // exit;
        $this->load->view('package/package',$record_packages);

    }

    public function package_getdata(){ 
         $packages = $this->genral_model->get_one_records('igservices' , 'ig_service_description','packageId',$_POST['id']);
       foreach ($packages as $key => $value) {
        $str['id'] = $value->id;
        $str['packageQty'] = $value->packageQty;
        $str['serviceType'] = $value->serviceType;
        $str['packageTitle'] = $value->packageTitle;
        $str['packagePrice'] = $value->packagePrice;
        $str['package_description'] = $value->package_description;
        $str['priceUnit'] = $value->priceUnit;
        $str['url'] = base_url('buy-'.$value->packageQty.'-tiktok-'.$value->serviceType);
       }
       echo json_encode($str);
        
    }

    public function purchase_package($quantity, $stype){
        $record_packages['user_data'] = $this->genral_model->get_stype_qun_data('serviceType',$stype,'packageQty' ,$quantity,'igservices');
        if(empty($record_packages['user_data'])){
            show_404();
        }
        $record_packages['alldata'] = $this->genral_model->select_all_data('serviceType',$stype,'igservices');
        $record_packages["featured"] = $this->genral_model->get_packagerecords('ig_service_description','igservices','packageId','displayQty' ,1);
        
        $this->load->view('package/purchase_package',$record_packages);
            /*$get_title = $this->genral_model->get_one_records('igservices' , 'ig_service_description','packageId',$id);

            print_r();
            exit;
            $packages['user_data'] = $this->genral_model->get_one_records('igservices' , 'ig_service_description','packageId',$id);

            $packages['alldata'] = $this->genral_model->get_records('igservices' , 'ig_service_description','packageId');
         $this->load->view('package/purchase_package',$packages);*/
        /*
        $this->load->view('package/package',$data);*/
    }

    public function get_user_data_api(){
        $name = $_POST['name'];
        $this->load->library('instapi');
        $packages = $this->instapi->get_tiktok_user($name);
         echo json_encode($packages['data']);
        /*
        $this->load->view('package/package',$data);*/
    }

    public function aboutus(){
        $this->load->view('aboutUs/about_us');

    }

    
    

}