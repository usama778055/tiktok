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

        $data = array('act' => 'get_tiktok_posts',
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
        $apiUrl = "http://67.205.140.109:3000/get_data";
        $authKey = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJvQXV0aCI6InRvc2VlZiJ9.ilLOIWfXQZv-klGwCfFCEuHuDV3kMyXRisidCxDamD4';
        /*$header = array();
        $header[] = 'Authorization: OAuth '.$authKey;

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        return $response;*/
		$jsonData = json_encode($data);
		$header = array();
		$header[] = 'x-access-token:'.$authKey;
		$header[] = 'Content-Type:application/json';

		$ch = curl_init($apiUrl);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch,CURLOPT_POSTFIELDS,$jsonData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$response = curl_exec($ch);
		return $response;
    }
}
