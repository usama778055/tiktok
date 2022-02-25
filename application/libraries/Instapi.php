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
        //echo "<pre>";print_r($user);exit;
        return $user;
    }
    public function insta_user($data){
    	/*$apiUrl = "http://67.205.140.109:3000/get_data";
        $authKey = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJvQXV0aCI6InRvc2VlZiJ9.ilLOIWfXQZv-klGwCfFCEuHuDV3kMyXRisidCxDamD4';
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
    	*/
		return $data=$this->getTestResponse();
    }
	public function getTestResponse()
	{
		return $response="{\"data\":{\"bio\":\"CEO of #RockTok\",\"followers\":\"50.9M\",\"following\":\"3\",\"full_name\":\"The Rock\",\"likes\":\"285.9M\",\"post_links\":[{\"link\":\"https://www.tiktok.com/@therock/video/7068074743605333294\",\"src\":\"https://p16-sign.tiktokcdn-us.com/obj/tos-useast5-p-0068-tx/73c037b98cc244e0812e77db912106d2?x-expires=1645718400&x-signature=CpkUhHb%2B4pjB3nOBB0dnDYegWiU%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7064682803601984814\",\"src\":\"https://p16-sign.tiktokcdn-us.com/obj/tos-useast5-p-0068-tx/0cf5b43f40364d75b982b2c905cfdcbc_1644874648?x-expires=1645718400&x-signature=QqAnqHxzdZAE2QSjkaWBXviw%2FpA%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7063495679296998702\",\"src\":\"https://p16-sign.tiktokcdn-us.com/obj/tos-useast5-p-0068-tx/6dc065e2e52144378c6eb541927941a7_1644598248?x-expires=1645718400&x-signature=%2F4L%2BxmkylTVZss0K8irTHaKd9KU%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7062477024371297582\",\"src\":\"https://p19-sign.tiktokcdn-us.com/obj/tos-useast5-p-0068-tx/ae69b1a4fe304720853865b62d922c7c_1644361075?x-expires=1645718400&x-signature=6rkD2kTt188aLkD%2Btshs3wDeiHA%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7062034767763655983\",\"src\":\"https://p16-sign.tiktokcdn-us.com/obj/tos-useast5-p-0068-tx/7661f8930eb34004894bbc2f27a44710_1644258103?x-expires=1645718400&x-signature=uA8YoVmpKpty%2FFoBzIFzIW7o0AA%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7061694839141715246\",\"src\":\"https://p16-sign.tiktokcdn-us.com/obj/tos-useast5-p-0068-tx/681595b91a66471c8ca7e33f28cd9f5f_1644178956?x-expires=1645718400&x-signature=R6JOi0Vu3M9LaKfl%2BtmnA8YXCiI%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7060469360590277935\",\"src\":\"https://p16-sign.tiktokcdn-us.com/obj/tos-useast5-p-0068-tx/6227c29946d7413aa177cfe1b90c2369_1643893635?x-expires=1645718400&x-signature=BVj9CCCb1R0OvOyVls4Yp4udj0A%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7059892875622124846\",\"src\":\"https://p16-sign.tiktokcdn-us.com/obj/tos-useast5-p-0068-tx/e37ba7c6afb14581934ae9f21d2eff0d_1643759406?x-expires=1645718400&x-signature=FYmZkPsQeW%2BZeQLob0i2fBCTRcE%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7056835183529577775\",\"src\":\"https://p16-sign.tiktokcdn-us.com/obj/tos-useast5-p-0068-tx/45d73687f2bd4d3e83174a1f005ff7b8_1643047480?x-expires=1645718400&x-signature=FmGKbw0xdvQL4fRE7McXEfGKw%2BA%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7054346830397787439\",\"src\":\"https://p16-sign.tiktokcdn-us.com/obj/tos-useast5-p-0068-tx/022552677c1b4b5cba74a9ba61c525d6_1642468118?x-expires=1645718400&x-signature=Y3Z42TtuPPBYCU1npp0phdkPsI4%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7046458565296622894\",\"src\":\"https://p19-sign.tiktokcdn-us.com/obj/tos-useast5-p-0068-tx/24ab83f9c92645b8a3522b8d6b5990c1_1640631491?x-expires=1645718400&x-signature=U6Z%2FZeUJbhn%2F0j%2BRarxwpWnqDTU%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7045102128255290630\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/a37aa635a8ea4739ac445534cae4c68f_1640315666?x-expires=1645718400&x-signature=kM%2F%2BUANLiEEMAIf2hO8%2BMjAShak%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7045096017913531653\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/34c39f5f528e4ead811d2a3c291be8a0_1640314243?x-expires=1645718400&x-signature=Tjm7jRqcSKWrTrl1HSbmC0ok%2BFs%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7041997751718137094\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/33edee8714384145959ee767b1d079e1_1639592871?x-expires=1645718400&x-signature=Ad2Mx1YrABHRITKLj7CfxknXsw0%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7030204102726438149\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/f73157a62af54ac7862d52b84fab8f9b_1636846954?x-expires=1645718400&x-signature=DG5hiiG5Mp4PuudkdAZ5v80XPug%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7029082666301623598\",\"src\":\"https://p16-sign.tiktokcdn-us.com/obj/tos-useast5-p-0068-tx/a4c6195188664a36a415e5a152f22917_1636585853?x-expires=1645718400&x-signature=tsZCQFrxJsCFnUT3IRDGc4mPKpc%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7024325325257493766\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/7b69fec928b44fbea98b83838f2f0d53_1635478190?x-expires=1645718400&x-signature=xXhQZLsmgWukHajQDrxWGaA%2F5i8%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7022393040451030278\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/35765ea83a8c40b895db7b88dad96cad_1635028296?x-expires=1645718400&x-signature=3vnQEOLBA3CD%2BisE282pdok8%2FGg%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7021229718695464239\",\"src\":\"https://p16-sign.tiktokcdn-us.com/obj/tos-useast5-p-0068-tx/5e2634aa8e3849c3b8861070504344f1_1634757446?x-expires=1645718400&x-signature=x3fi602pzqpUUg0hVsVsUT2eKGw%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7016541510074141958\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/46b3c1655466479a9de7efe5c331d870_1633665882?x-expires=1645718400&x-signature=2oJWXbOEJoEfe%2BO7UxOkgjTFeUg%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7016296123530743046\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/93a1ff269f894c959b9f633f5108392b_1633608749?x-expires=1645718400&x-signature=12jlIakOTAOL01OK7KehsIiYyvc%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7005587944203422981\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/31fa84b3708f421d8d4132b6e41cabad_1631115559?x-expires=1645718400&x-signature=ndEyTGfEGvJ8SDgcdpyKLU6I2wk%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/7000710659188985093\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/aac5c1aa1738459e8f7375ca50508329_1629979974?x-expires=1645718400&x-signature=Q%2F1xd%2B62Lc2YwwAjUrA6mJRMfYU%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/6999036988741471494\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/fa97d42d8bd34de197fa9cf29830e613_1629590291?x-expires=1645718400&x-signature=2PHWhLRQJXSR3rX8uVKB7LfJdBg%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/6994968555548675333\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/17fd196e980947519165d55d3f8a73e2_1628643035?x-expires=1645718400&x-signature=mEzXaUUugBqbhA08THDmwnJNNsc%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/6993343840778292486\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/e3722e44db914c009910ed6e611bf820_1628264750?x-expires=1645718400&x-signature=MuWMnEw9rhTWhj7olH%2B4HeMS58c%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/6988991439984266501\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/286d1a0ea0614a66a28ea566ebfea2be_1627251381?x-expires=1645718400&x-signature=%2FCe6Bid0AxRbaIJ7hY9ghYKl2Ks%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/6988598254795640070\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/9bd41768830148cd8cbd3f46ed78c9d7_1627159836?x-expires=1645718400&x-signature=SdMAip29vZ83mH32xMvakLgek6U%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/6987004636360084741\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/834ea338b6e24c9c8dc9da5f5fc381d5_1626788801?x-expires=1645718400&x-signature=lK4On%2B59ebaQVD%2FoOXn40xAKD%2Bc%3D\"},{\"link\":\"https://www.tiktok.com/@therock/video/6951123413905837318\",\"src\":\"https://p16-sign-va.tiktokcdn.com/obj/tos-maliva-p-0068/45feb8e0358e4d49bd3b0511f574a93b_1618434543?x-expires=1645718400&x-signature=hu7q%2BzwxPxy1O87iAqqX8Lnuwgs%3D\"}],\"private\":0,\"profile_image\":\"https://p16-sign-va.tiktokcdn.com/musically-maliva-obj/1647596478025734~c5_100x100.jpeg?x-expires=1645783200&x-signature=5xmdcJAIFRq8O%2F%2FsA9havrDIT%2BY%3D\",\"user_name\":\"therock\"}}";
		//return $data=json_decode($response,true);
	}
}
