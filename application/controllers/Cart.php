<?php
class Cart extends CI_Controller {

    public function index()
    {
        echo 'Hello World!';
    }

    public function add_to_cart()
    {
        //add to cart functionality will be added here
    }

    public function checkout()
    {
        $this->load->view('cart/checkout');
    }
}