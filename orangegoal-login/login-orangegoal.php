<?php
	/* 
	* Plugin Name: Custom orangegoal Wordpress Login
	* Description: Login to orangegoal's Digital Waiter Platform
	* Version: 1.0.0
	* Author: Humberto López
	*/
	class Orangegoal_Login_Plugin {
		// Esto ocurre cuando se activa el plugin
		public static function plugin_activated() {
			$page_definitions = array(
				'member-login' => array(
					'title' => __('Please, sign in to Orangegoal Digital Marketing', 'login-orangegoal'),
					'content' => '[login-orangegoal-form]'
					),
				'member-account' => array(
					'title' => __('Welcome to Orangegoal Digital Marketing','login-orangegoal'),
					'content' => '[your-orangegoal-account]'
					),
				);
			foreach ($page_definitions as $slug => $page) {
				$query = new WP_Query('pagename='. $slug);
				if(! $query->have_posts() ) {
					wp_insert_post(
						array(
							'post_content' => $page['content'],
							'post_name' => $slug,
							'post_title' => $page['title'],
							'post_status' => 'publish',
							'post_type' => 'page',
							'ping_status' => 'closed',
							'comment_status' => 'closed',
							)
					);
				}
			}
		}
		// crear shortcode
		public function render_login_form($attributes,$content=null) {
			$default_attributes = array('show_title'=>true);
			$attributes = shortcode_atts($default_attributes,$attributes);
			$show_title = $attributes['show_title'];
			// Check if the user just registered
			$attributes['registered'] = isset( $_REQUEST['registered'] );

			if (is_user_logged_in()){
				$msg = __("You are already signed in! You should go and <a href='%s'>edit your account</a>, tell us a little more about your business!",'login-orangegoal');				
				return sprintf($msg,wc_customer_edit_account_url());
			}
			//error messages
			$errors = array();
			if(isset($_REQUEST['login'])){
				$error_codes = explode(',',$_REQUEST['login']);
				foreach($error_codes as $code){
					$errors []= $this->get_error_message($code);
				}
			}
			$attributes['errors'] = $errors;

			$attributes['redirect'] = '';
			if(isset($_REQUEST['redirect_to'])) {
				$attributes['redirect'] = wp_validate_redirect($_REQUEST['redirect_to'],$attributes['redirect']);
			}
			return $this->get_template_html('orangegoal_login_form',$attributes);			
		}
		private function get_template_html($template_name,$attributes = null){
			if(!$attributes){
				$attributes = array();
			}
			ob_start();
			do_action('personalize_login_before_' . $template_name);
			require('templates/'.$template_name.'.php');
			do_action('personalize_login_after_'.$template_name);
			$html = ob_get_contents();
			ob_end_clean();
			return $html;
		}
		//private
		public function redirect_logged_in_user($redirect_to=null){
			$user = wp_get_current_user();
			if(user_can($user,'manage_options')){
				if($redirect_to){
					wp_safe_redirect($redirect_to);
				} else {
					wp_redirect(admin_url());
				}
			} else {
				wp_redirect(wc_customer_edit_account_url());
			}
		}
		function redirect_to_orangegoal_login(){
			if($_SERVER['REQUEST_METHOD'] == 'GET'){
				$redirect_to = isset($_REQUEST['redirect_to']) ? $_REQUEST['redirect_to'] : null;
				if(is_user_logged_in()){
					$this->redirect_logged_in_user($redirect_to);
					exit;
				}
				$login_url = home_url('member-login');
				if(!empty($redirect_to)) {
					$login_url = add_query_arg('redirect_to',$redirect_to,$login_url);
				}
				wp_redirect($login_url);
				exit;
			}
		}
		public function redirect_after_login($redirect_to,$requested_redirect_to,$user){
			$redirect_url = home_url();
			if(!isset($user->ID)) {
				return $redirect_url;
			}
			if(user_can($user,'manage_options')){
				if($requested_redirect_to == ''){
					$redirect_url = admin_url();
				} else {
					$redirect_url = $redirect_to;
				}
			} else {
				$redirect_url = wc_customer_edit_account_url();
			}
			return wp_validate_redirect($redirect_url,home_url());
		}
		function maybe_redirect_at_authenticate($user,$username,$password){
			if($_SERVER['REQUEST_METHOD']==='POST'){
				if(is_wp_error($user)){
					$error_codes = join(',',$user->get_error_codes());
					$login_url = home_url('member-login');
					$login_url = add_query_arg('login',$error_codes,$login_url);
					wp_redirect($login_url);
					exit;
				}
			}
			return $user;
		}
		private function get_error_message($error_code){
			switch($error_code){
				case 'email':
				return __('The email address you entered is not valid. Please, try again with a valid address.','login-orangegoal');
				case 'existing_user_login':
				$msglogin = __("An account exists with this email address. Maybe, you are trying <a href='%s'>to login</a>?",'login-orangegoal');
				return sprintf($msglogin,home_url('member-login'));
				case 'closed':
				return __('Registering new users is currently not allowed.','login-orangegoal');
				case 'empty_username':
				return __('Please, tell us your e-mail address.','login-orangegoal');
				case 'empty_password':
				return __('You need your password to login.','login-orangegoal');
				case 'invalid_username':
				return sprintf(__("We don't have any users with that e-mail address. Maybe you aren't registered with us already. <a href='%s'>Go, choose a FREE Diagnostic and register!</a>",'login-orangegoal'),home_url());
				case 'invalid_email':
				return sprintf(__("We don't have any users with that e-mail address. Maybe you aren't registered with us already. <a href='%s'>Go, choose a FREE Diagnostic and register!</a>",'login-orangegoal'),home_url());
				case 'incorrect_password':
				$err = __("The password you entered wasn't quite right. <a href='%s'>Did you forget your password</a>?",'login-orangegoal');
				return sprintf($err,wp_lostpassword_url());
				case 'password_not_matched':
				return __("<strong>ERROR:</strong> Passwords doesn't match. Make sure to write the same password.");
				case 'password_too_short':
				return __("<strong>ERROR:</strong> Passwords must be at least eight characters long");
				case 'no_diagnostic_chosen':
				return __("<strong>ERROR:</strong> You haven't chosen a free diagnostic.");
				default:
					break;
			}
			return __('An unknown error ocurred. Please try again later.','login-orangegoal');
		}
		public function redirect_after_logout() {			
			$redirect_url = home_url('member-login/?logged_out=true');
			wp_safe_redirect($redirect_url);
			exit;
			$attributes['logged_out'] = isset($_REQUEST['logged_out']) && $_REQUEST['logged_out'] == true;
		}
		// register orangegoal new user
		public function render_register_form($attributes,$content=null){
			$default_attributes = array('show_title'=>true);
			$attributes = shortcode_atts($default_attributes,$attributes);
			if(is_user_logged_in()){
				$msg = __("You are already signed in! You should go and <a href='%s'>edit your account</a>, tell us a little more about your business!",'login-orangegoal');				
				return sprintf($msg,wc_customer_edit_account_url());
			} elseif (!get_option('users_can_register')) {
				return __('Registering new users is currently not allowed','login-orangegoal');
			} else {
				$attributes['errors'] = array();
				if(isset($_REQUEST['register-errors'])){
					$error_codes = explode(',',$_REQUEST['register-errors']);
					foreach ($error_codes as $error_code) {
						$attributes['errors'] []= $this->get_error_message($error_code);
					}
				}
				return $this->get_template_html('orangegoal_register_form',$attributes);
			}			
			$attributes['registered'] = isset($_REQUEST['registered']);
		}
		//redirect after register 
		public function redirect_to_dashboard() {
			if ('GET' == $_SERVER['REQUEST_METHOD']) {
				if(is_user_logged_in()){
					$this->redirect_logged_in_user();
				} else {
					wp_redirect('#login');
				}
				exit;
			}
		}		
		private function register_user($email,$first_name,$last_name){
			$password = $_POST['password'];
			$choose_diagnostic = $_POST['choose_diagnostic'];
			$errors = new WP_Error();
			if(!is_email($email)) {
				$errors->add('email',$this->get_error_message('email'));
				return $errors;
			}
			if (username_exists($email) || email_exists($email)) {
				$errors->add('email_exists',$this->get_error_message('email_exists'));
			}
			if ($_POST['password'] !== $_POST['repeat_password']) {
				$errors->add('password_not_matched',$this->get_error_message('password_not_matched'));
				return $errors;
			}
			if (strlen($_POST['password']) < 8 ) {
				$errors->add('password_too_short',$this->get_error_message('password_too_short'));
				return $errors;
			}
			if (empty($choose_diagnostic)){
				$errors->add('no_diagnostic_chosen',$this->get_error_message('no_diagnostic_chosen'));
				return $errors;
			}
			$user_data = array(
					'user_login' => $email,
					'user_email' => $email,
					'first_name' => $first_name,
					'last_name' => $last_name,
					'nickname' => $first_name,
					'user_pass' => $password,
				);
			$user_id = wp_insert_user($user_data);
			wp_new_user_notification($user_id,$password);
			update_user_meta($user_id,'choose_diagnostic',$_POST['choose_diagnostic']);
			return $user_id;
		}
		public function do_register_user() {
			if('POST' == $_SERVER['REQUEST_METHOD']){
				$redirect_url = home_url('#login');
				if(!get_option('users_can_register')) {
					$redirect_url = add_query_arg('register-errors','closed',$redirect_url);
				} else {
					$email = $_POST['email'];
					$first_name = sanitize_text_field($_POST['first_name']);
					$last_name = sanitize_text_field($_POST['last_name']);
					$result = $this->register_user($email,$first_name,$last_name);
					if(is_wp_error($result)) {
						$errors = join(',',$result->get_error_codes());
						$redirect_url = add_query_arg('register-errors',$errors,$redirect_url);
					} else {
						$redirect_url = wc_customer_edit_account_url();
						$redirect_url = add_query_arg('registered',$email,$redirect_url);
					}
				}
				wp_redirect($redirect_url);
				exit;
			}
		}
		public function __construct() {
			add_shortcode('login-orangegoal-form',array($this,'render_login_form'));
			add_action('login_form_login',array($this,'redirect_to_orangegoal_login'));
			add_filter( 'authenticate', array( $this, 'maybe_redirect_at_authenticate' ), 101, 3 );
			add_action('wp_logout',array($this,'redirect_after_logout'));
			add_shortcode('custom-orangegoal-register',array($this,'render_register_form'));
			add_action('login_form_register',array($this,'redirect_to_dashboard'));
			add_action('login_form_register',array($this,'do_register_user'));
			add_filter('login_redirect',array($this,'redirect_after_login'),10,3);
		}
	}
	$orangegoal_login_plugin_start = new Orangegoal_Login_Plugin();
	// Activar o desactivar el plugin
	register_activation_hook(__FILE__,array('Orangegoal_Login_Plugin','plugin_activated'));
?>