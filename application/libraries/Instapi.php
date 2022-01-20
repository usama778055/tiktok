<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instapi{
    public function get_user($username = ''){
        $data = array(  'act' => 'get_user_posts', 
                        'user_name' => $username);
        $userData = $this->insta_user($data);
        $user = json_decode($userData, true);
        return $user;
    }
    
    public function get_igtv($username = ''){
        $data = array(  'act' => 'get_user_igtv', 
                        'user_name' => $username,
                        'type' => 'igtvviews' );
        $userData = $this->insta_user($data);
        $user = json_decode($userData, true);
        return $user;
    }
    
    public function get_tiktok_user($username){
        $data = array(  'act' => 'get_tiktok_posts', 
                'user_name' => $username);
        $userData = $this->insta_user($data);
        $user = json_decode($userData, true);
        
        return $user;
    }

    public function get_user_nd_stories($username){
        $data = array(  'act' => 'get_user_and_stories', 
                'user_name' => $username);
        
        $userData = $this->insta_user($data);
        $user = json_encode($userData, true);
        
        return $user;
    }
    public function insta_user($data){
        $apiUrl = "http://devapi.digitalaimz.com/find/";
        $authKey = 'u#3n2@r!'; 
        $header = array();
        $header[] = 'Authorization: OAuth '.$authKey;

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        return $response;
    }
}