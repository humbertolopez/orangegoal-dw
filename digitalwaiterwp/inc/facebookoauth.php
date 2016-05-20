<?php

session_start();

function facebook_oauth_redirect()
{
	global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;
	require_once("../wp-load.php");
	//construct URL and redirect
	$app_id = '586098551558393';
	$redirect_url = get_site_url() . "/wp-admin/admin-ajax.php?action=facebook_oauth_callback";
	$permission = "email,first_name,last_name";

	$final_url = "https://www.facebook.com/dialog/oauth?client_id=" . urlencode($app_id) . "&redirect_uri=" . urlencode($redirect_url) . "&permission=" . $permission;

	header("Location: " . $final_url);
	die();
}

add_action("wp_ajax_facebook_oauth_redirect", "facebook_oauth_redirect");
add_action("wp_ajax_nopriv_facebook_oauth_redirect", "facebook_oauth_redirect");

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function facebook_oauth_callback()
{
	global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;
	require_once("../wp-load.php");

	if(isset($_GET["code"]))
    {   
        $app_id = '586098551558393';
        $app_secret = '617095256f0d3f66c2b49e245c280d9d';
        $token_and_expire = file_get_contents("https://graph.facebook.com/oauth/access_token?client_id=" . $app_id . "&redirect_uri=". get_site_url() . "/wp-admin/admin-ajax.php?action=facebook_oauth_callback" . "&client_secret=" . $app_secret . "&code=" . $_GET["code"]);
        
        parse_str($token_and_expire, $_token_and_expire_array);
        
        
        if(isset($_token_and_expire_array["access_token"]))
        {   
            $access_token = $_token_and_expire_array["access_token"];
            $user_information = file_get_contents("https://graph.facebook.com/me?access_token=" . $access_token . "&fields=email,first_name,last_name");
        	$user_information_array = json_decode($user_information, true);

        	$email = $user_information_array["email"];
        	$first_name = $user_information_array["first_name"];
            $last_name = $user_information_array["last_name"];
        	if(username_exists($first_name))
			{
				$user_id = username_exists($first_name);
				wp_set_auth_cookie($user_id);
                update_user_meta($user_id, "facebook_access_token", $access_token);
				header('Location: ' . get_site_url() .'/my-account/edit-account');
			}
			else
			{
				//create a new account and then login
				wp_create_user($first_name, generateRandomString(), $email);
				$user_id = username_exists($first_name);
				wp_set_auth_cookie($user_id);
                update_user_meta($user_id, "facebook_access_token", $access_token);
				header('Location: ' . get_site_url() .'/my-account/edit-account');
			}
        }
        else
        {   
            header("Location: " . get_site_url());
        }
    }
    else
    {
    	header("Location: " . get_site_url());
    }

    die();
}
add_action("wp_ajax_facebook_oauth_callback", "facebook_oauth_callback");
add_action("wp_ajax_nopriv_facebook_oauth_callback", "facebook_oauth_callback");