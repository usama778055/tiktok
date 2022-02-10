<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Findinstauser
{
    private $_CI;
    public function __construct()
    {
        $this->_CI = &get_instance();
        $this->_CI->load->library('form_validation');
        $this->_CI->load->helper('file');
    }

    public function findUser()
    {
        $this->createUserSession();
        $userArray = $this->getUserData();
        $profile_data = $this->prepageUserData($userArray);
        $this->_CI->session->set_userdata('profile_data', $profile_data);
        $result = array('success' => 1, 'data' => $userArray);
        return $result;
    }


    private function getUserData()
    {
        $this->_CI->load->library('instapi');

        $user_name = $this->_CI->session->userdata('user_name');
		$package = $this->_CI->session->userdata('package_detail');
        $stype = $package->serviceType;
        $instaRes =$this->_CI->instapi->get_tiktok_user($user_name);
		$user_data = $instaRes['data'];
		//echo "<pre>";print_r($user_data);exit;
		/*$instaProfile = (!is_array($user_data) || !isset($user_data['user'])) ?
            'Profile not found. Try again.' : (
                ($user_data['user']['is_private']) ?
                'Profile is private.' : $user_data
            );*/
		$instaProfile = (!is_array($user_data) || !isset($user_data['user_name'])) ?
			'Profile not found. Try again.' : $user_data;

		if (!is_array($instaProfile)) {
            $error = array('success' => 0, 'message' => $instaProfile);
            exit(json_encode($error));
        }

        return $instaProfile;
    }

    public function prepageUserData($user)
    {

        //$this->saveimgaeFromUrl($_SESSION['user_name'], $user['profile_pic']);     // Save user image.

        /*unset($_SESSION['load_more']);
        if ($user['next_page']) : $_SESSION['load_more'] = $user['next_token'];
        endif;*/

        $user_data = array();
        $user_data['full_name'] = $user['full_name'];
        $user_data['user_name'] = $user['user_name'];
        $user_data['followers'] = $user['followers'];
        $user_data['following'] = $user['following'];
        $user_data['likes'] = $user['likes'];
		$user_data['profileImage'] = '';
		$user_data['post_count'] = '';
        //$user_data['profile_id'] =  $user['user_id'];

        //$user_data['business_profile'] = '';

        return $user_data;
    }

    public function createUserSession()
    {
        $pckg = $this->_CI->session->package_detail;
        $pckg = (object) $pckg;
        $user_name = $this->_CI->input->post('user_name', true);

        $user_name = $this->_CI->security->xss_clean(trim($user_name));
        $error_message = ($user_name == '') ?
            'Try again with proper Username.' : (
                (!preg_match("#^[a-zA-Z0-9_\.\]]+$#", $user_name)) ?
                'Please enter valid instagram Instagram username.' : '');
        if ($error_message != '') {
            $error = array('success' => 0, 'message' => $error_message);
            exit(json_encode($error));
        }
        $orderId = time() . $pckg->service_id;
        $this->_CI->session->set_userdata('new_order', $orderId);
        $this->_CI->session->set_userdata('user_name', $user_name);
    }

    public function saveUserTrafic()
    {
        $this->_CI->load->model('Mob_admin');
        $pckgData = $_SESSION['package_detail'];
        $user_data = array(
            'profileId' => $_SESSION['user_name'],
            'user_email' => $_SESSION['user_email'],
            'ig_detail' => json_encode($_SESSION['profile_data']),
            'service_id' => $pckgData['id'],
            'conversiondate' => date("Y-m-d H:i:s"),
        );
        return $this->_CI->Mob_admin->add_user($user_data);
    }

    public function saveimgaeFromUrl($profileId, $url = '')
    {
        if ($url != '') {
            $dirpath = APPPATH . '../assets/images/profiles/mob_' . $profileId . '.jpg';
            $content = file_get_contents($url);
            file_put_contents($dirpath, $content);
        }
    }

    public function loadMore()
    {
        $loadmore = $_SESSION['load_more'];
        $uniqe_id = $_SESSION['profile_data']['profile_id'];
        $package = $_SESSION['package_detail'];
        $package = (array) $package;
        $data = array(
            'act' => 'get_next_posts',
            'user_id' => $uniqe_id,
            'next' => $loadmore,
            'stype' => $package['serviceType']
        );
        $this->_CI->load->library('instapi');
        $user_data = $this->_CI->instapi->insta_user($data);
        if (empty($user_data)) {
            return array('success' => 0, 'message' => 'It seems an error occoured. Please try again later.');
        }

        $data_array = json_decode($user_data, true);
        $userArray = $data_array['data'];
        $user = $userArray['user'];

        unset($_SESSION['load_more']);
        if ($user['next_page']) : $_SESSION['load_more'] = $user['next_token'];
        endif;

        $result = array('success' => 1, 'data' => $userArray);
        return $result;
    }
}
