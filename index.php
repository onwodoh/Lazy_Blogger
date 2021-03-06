<?php
        
	session_start();
        require_once __DIR__ . '/src/Facebook/autoload.php';

	$fb = new Facebook\Facebook([
		'app_id' => 'APP_ID',
		'app_secret' => 'AP_SECRET',
		'default_graph_version' => 'v2.4',
	]);

	$helper = $fb->getRedirectLoginHelper();

$permissions = ['email','user_likes']; // optional
	

	// getting basic info about user
try {
                $token='APP_TOKEN';
		$profile_request = $fb->get('/me/likes?fields=id',$token);
		$profile = $profile_request->getGraphEdge()->asArray();
                $id_one=$profile[0][id];
                $id_two=$profile[1][id];
                $id_three=$profile[2][id];

                $first_page= ($fb->get('/'. $id_one . '/picture?type=large',$token));
                $first_page_link = ($fb->get('/'. $id_one . '/?fields=link',$token));
                $second_page= ($fb->get('/'. $id_two . '/picture?type=large',$token));
                $second_page_link = ($fb->get('/'. $id_two . '/?fields=link',$token));
                $third_page= ($fb->get('/'. $id_three . '/picture?type=large',$token));
                $third_page_link = ($fb->get('/'. $id_three . '/?fields=link',$token));


               $first_page_link= ($first_page_link->getGraphNode()->asArray()[link]);
               $second_page_link= ($second_page_link->getGraphNode()->asArray()[link]);
               $third_page_link= ($third_page_link->getGraphNode()->asArray()[link]);
               
                $pic1=$first_page->getHeaders()[Location];
                $pic2=$second_page->getHeaders()[Location];
                $pic3=$third_page->getHeaders()[Location];
		
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// redirecting user back to app login page
		header("Location: ./");
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	
	

  	// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']

	// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www 
	$loginUrl = $helper->getLoginUrl('http://ogonwodoh.com/index.php', $permissions);
	
?>
