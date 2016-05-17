<?php
	//facebook auth api
	require_once('inc/facebookoauth.php');
	class Facebook_Login_Widget extends WP_Widget 
	{
	    public function __construct() 
	    {
	        parent::__construct("facebook_login_widget", "Facebook Login", array("description" => __("Display a Facebook Login Button")));
	    }
	        
	    public function form( $instance ) 
	    {
	        // Check values
	        if($instance) 
	        {
	            $title = esc_attr($instance['title']);
	            $app_key = $instance['app_key'];
	            $app_secret = $instance['app_secret'];
	        } 
	        else 
	        {
	            $title = '';
	            $app_key = '';
	            $app_secret = '';
	        }
	        ?>

	        <p>
	            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'facebook_login_widget'); ?></label> 
	            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	        </p>

	        <p>
	            <label for="<?php echo $this->get_field_id('app_key'); ?>"><?php _e('App ID:', 'facebook_login_widget'); ?></label>
	            <input type="text" class="widefat" id="<?php echo $this->get_field_id('app_key'); ?>" name="<?php echo $this->get_field_name('app_key'); ?>" value="<?php echo $app_key; ?>" />
	        </p>
	        
	        <p>
	            <label for="<?php echo $this->get_field_id('app_secret'); ?>"><?php _e('App Secret:', 'facebook_login_widget'); ?></label>
	            <input type="text" class="widefat" id="<?php echo $this->get_field_id('app_secret'); ?>" name="<?php echo $this->get_field_name('app_secret'); ?>" value="<?php echo $app_secret; ?>" />
	        </p>
	        
	        <?php
	    }
	        
	    public function update( $new_instance, $old_instance ) 
	    {
	        $instance = $old_instance;
	        $instance['title'] = strip_tags($new_instance['title']);
	        $instance['app_key'] = strip_tags($new_instance['app_key']);
	        $instance['app_secret'] = strip_tags($new_instance['app_secret']);
	        
	        update_option("facebook_app_id", $new_instance['app_key']);
	        update_option("facebook_app_secret", $new_instance['app_secret']);
	        
	        return $instance;
	    }
	        
	    public function widget( $args, $instance ) 
	    {
	        extract($args);
	        
	        $title = apply_filters('widget_title', $instance['title']);
	        echo $before_widget;
	        
	        if($title) 
	        {
	            echo $before_title . $title . $after_title ;
	        }
	        
	        if(is_user_logged_in()) 
	        {
	            ?>
	                <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Logout"><input type="button" value="Logout" /></a>
	            <?php
	        }
	        else
	        {
	            ?>
	                <a href="<?php echo site_url() . '/wp-admin/admin-ajax.php?action=facebook_oauth_redirect'; ?>"><input type="button" value="Login Using Facebook" /></a>
	            <?php
	        }
	        
	        echo $after_widget;
	    }
	}
	register_widget("Facebook_Login_Widget");
	// remove required fields: last name and first name 
	add_filter('woocommerce_save_account_details_required_fields','unrequire_woocommerce_fields');
	function unrequire_woocommerce_fields($fields){
		unset($fields['account_last_name']);
		unset($fields['account_first_name']);
		return $fields;
	}
	/**
	 * To display additional field at My Account page
	 * Once member login: edit account
	 */
	add_action( 'woocommerce_edit_account_form', 'my_woocommerce_edit_account_form' );
	function my_woocommerce_edit_account_form() {
		$user_id = get_current_user_id();
		$user = get_userdata( $user_id );
		if ( !$user )
			return;
		//about business
		$businessname = get_user_meta($user_id,'businessname',true);
		$businesslocationcity = get_user_meta($user_id,'businesslocationcity',true);
		$businesslocationstate = get_user_meta($user_id,'businesslocationstate',true);
		$advertised = get_user_meta($user_id,'advertised',true);
		$businessdescription = get_user_meta($user_id,'businessdescription',true);
		$businesskey = get_user_meta($user_id,'businesskey',true);
		//about competitors
		$aboutcompetitors = get_user_meta($user_id,'aboutcompetitors',true);
		//orangegoal newsletter
		$orangenews = get_user_meta($user_id,'orangenews',true);
	?>
		<!-- about business -->		
		<fieldset>
			<legend>About your business</legend>
			<p><label for="businessname">Business Name:</label></p>
			<p><input type="text" name="businessname" value="<?php echo esc_attr($businessname); ?>" class="input-text businessname" /></p>
			<p>
				<label for="busineslocation">Location, city and state:</label>
			</p>
			<p>
				<input type="text" name="businesslocationcity" value="<?php echo esc_attr($businesslocationcity); ?>" class="input-text" />
				<select title="Select state" name="businesslocationstate">
					<?php 
						$states = array("Alaska","Alabama","Arkansas","Arizona","California","Colorado","Connecticut","District of Columbia","Delaware","Florida","Hawaii","Iowa","Idaho","Illinois","Indiana","Kansas","Kentucky","Louisiana","Massachusetts","Maryland",
							"Maine","Michigan","Minnesota","Missouri","Mississippi","Montana","North Carolina","North Dakota","Nebraska","New Hampshire","New Jersey","New Mexico","Nevada","New York","Ohio","Oklahoma","Oregon","Pennsylvania",
							"Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Virginia","Vermont","Washington","Wisconsin","West Virginia","Wyoming");
						foreach ($states as $state) {
								?>
									<option value="<?php echo $state; ?>" <?php echo ($businesslocationstate == $state)? 'selected="selected"' : '' ?>><?php echo $state; ?></option>
								<?php
							}
					?>
				</select>
			</p>
			<div class="block advertised-wrapper">
				<div class="advertised-checkboxes">
					<label for="advertised">Where is it advertised?</label>
				</div>
				<?php
					$advertisedmean = array(
						'digital' => 'Digital media (adwords, facebook ads, etc.)',
						'printed' => 'Printed media (flyers, newspapers, magazines, etc.)',
						'tvradio' => 'TV and radio.'
						);
					foreach ($advertisedmean as $mean => $key) {
						?>
							<div class="advertised-checkboxes">
							<input type="checkbox" name="advertised[]" value="<?php echo $mean; ?>" <?php if(is_array($advertised)){ echo (in_array($mean,$advertised)) ? 'checked' : '';}?>/> <?php echo $key; ?>
							</div>
						<?php
					}
				?>				
			</div>
			<p class="block">
				<label for="businessdescription">A little description about your restaurant, what it serves and the kind of guests it has:</label>
			</p>
			<p class="block">
				<textarea name="businessdescription" id="businessdescription"><?php echo esc_attr($businessdescription); ?></textarea>
			</p>
			<p class="block">
				<label for="businesskey">The key advantage of your restaurant, what makes it better than any of its competitors?</label>
			</p>
			<p class="block">
				<textarea name="businesskey" id="businesskey"><?php echo esc_attr($businesskey); ?></textarea>
			</p>
		</fieldset>
		<!-- /about business -->
		<!-- about competitors -->
		<fieldset>
			<legend>About your competitors</legend>
			<p>
				<label for="aboutcompetitors">Who are your principal competitors?</label>
				<textarea name="aboutcompetitors" id="aboutcompetitors"><?php echo esc_attr($aboutcompetitors); ?></textarea>
			</p>
		</fieldset>
		<!-- /about competitors -->
		<!-- newsletter -->
		<p>
			<input type="checkbox" name="orangenews" value="orangenews" <?php if(!empty($orangenews)){ echo 'checked'; } else { echo ''; } ?>/> Subscribe to our newsletter and get novelties and promos about orangegoal’s services (we won’t bother you too much, that’s a promise).
		</p>		
		<!-- newsletter -->
	<?php
	 
	} // end func
	/**
	 * This is to save user input into database
	 * hook: woocommerce_save_account_details
	 */
	add_action('woocommerce_save_account_details','my_woocommerce_save_account_details');
	function my_woocommerce_save_account_details($user_id) {
			//about your business
			update_user_meta($user_id,'businessname',esc_attr($_POST['businessname']));
			update_user_meta($user_id,'businesslocationcity',esc_attr($_POST['businesslocationcity']));
			update_user_meta($user_id,'businesslocationstate',$_POST['businesslocationstate']);
			update_user_meta($user_id,'advertised',$_POST['advertised']);
			update_user_meta($user_id,'businessdescription',esc_attr($_POST['businessdescription']));
			update_user_meta($user_id,'businesskey',esc_attr($_POST['businesskey']));
			//about competitors
			update_user_meta($user_id,'aboutcompetitors',esc_attr($_POST['aboutcompetitors']));
			//about competitors
			update_user_meta($user_id,'orangenews',$_POST['orangenews']);
	} // end my_woocommerce_save_account_details
	add_action('show_user_profile','my_show_user_profile');
	add_action('edit_user_profile','my_show_user_profile');
	function my_show_user_profile($user) {
		//about business meta info
		$businessname = get_the_author_meta('businessname',$user->ID);
		$businesslocationcity = get_the_author_meta('businesslocationcity',$user->ID);
		$businesslocationstate = get_the_author_meta('businesslocationstate',$user->ID);
		$advertised = get_the_author_meta('advertised',$user->ID);
		$businessdescription = get_the_author_meta('businessdescription',$user->ID);
		$businesskey = get_the_author_meta('businesskey',$user->ID);
		//about competitors meta info
		$aboutcompetitors = get_the_author_meta('aboutcompetitors',$user->ID);
		// newsletter
		$orangenews = get_the_author_meta('orangenews',$user->ID);
		?>
			<h3>About the Business</h3>
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="businessname">Business name</label></th>
						<td><input type="businessname" name="businessname" id="businessname" value="<?php echo esc_attr($businessname); ?>" class="regular-text ltr"></td>
					</tr>			
					<tr>
						<th><label for="businesslocationcity">Business location — City</label></th>
						<td><input type="businesslocationcity" name="businesslocationcity" id="businesslocationcity" value="<?php echo esc_attr($businesslocationcity); ?>" class="regular-text ltr"></td>												
					</tr>
					<tr>
						<th><label for="businesslocationcity">Business location — State</label></th>
						<td>
						<select title="Select state" name="businesslocationstate">
							<?php 
								$states = array("Alaska","Alabama","Arkansas","Arizona","California","Colorado","Connecticut","District of Columbia","Delaware","Florida","Hawaii","Iowa","Idaho","Illinois","Indiana","Kansas","Kentucky","Louisiana","Massachusetts","Maryland",
									"Maine","Michigan","Minnesota","Missouri","Mississippi","Montana","North Carolina","North Dakota","Nebraska","New Hampshire","New Jersey","New Mexico","Nevada","New York","Ohio","Oklahoma","Oregon","Pennsylvania",
									"Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Virginia","Vermont","Washington","Wisconsin","West Virginia","Wyoming");
								foreach ($states as $state) {
										?>
											<option value="<?php echo $state; ?>" <?php echo ($businesslocationstate == $state)? 'selected="selected"' : '' ?>><?php echo $state; ?></option>
										<?php
									}
							?>
						</select>
						</td>
					</tr>
					<tr>
						<th><label for="advertised">Where is it advertised?</label></th>
						<td>
							<?php
								$advertisedmean = array(
									'digital' => 'Digital media (adwords, facebook ads, etc.)',
									'printed' => 'Printed media (flyers, newspapers, magazines, etc.)',
									'tvradio' => 'TV and radio.'
									);
								foreach ($advertisedmean as $mean => $key) {
									?>
										<p><input type="checkbox" name="advertised[]" value="<?php echo $mean; ?>" <?php if(is_array($advertised)){ echo (in_array($mean,$advertised)) ? 'checked' : '';}?>/> <?php echo $key; ?></p>
									<?php
								}
							?>
						</td>
					</tr>
					<tr>
						<th><label for="businessdescription">A little description about your restaurant, what it serves and the kind of guests it has:</label></th>
						<td><textarea name="businessdescription" id="businessdescription"><?php echo esc_attr($businessdescription); ?></textarea></td>
					</tr>
					<tr>
						<th><label for="businesskey">The key advantage of your restaurant, what makes it better than any of its competitors?</label></th>
						<td><textarea name="businesskey" id="businesskey"><?php echo esc_attr($businesskey); ?></textarea></td>
					</tr>
					<tr>
						<th><label for="orangenews">Is subscribed to orangegoal's newsletter?</label></th>
						<td><input type="checkbox" name="orangenews" value="orangenews" <?php if(!empty($orangenews)){ echo 'checked'; } else { echo ''; } ?>/></td>
					</tr>
				</tbody>
			</table>
			<h3>About the Competitors</h3>
			<table class="form-table">
				<tbody>
					<tr>
						<th><label for="aboutcompetitors">Who are your principal competitors?</label></th>
						<td><textarea name="aboutcompetitors" id="aboutcompetitors"><?php echo esc_attr($aboutcompetitors); ?></textarea></td>
					</tr>
				</tbody>
			</table>			
		<?php
	}// fin function my show user profile
	add_action('personal_options_update','my_save_extra_profile_fields');
	add_action('edit_user_profile_update','my_save_extra_profile_fields');	
	function my_save_extra_profile_fields($user_id) {
		if(!current_user_can('edit_user',$user_id))
			return false;
		//about your business
		update_user_meta($user_id,'businessname',esc_attr($_POST['businessname']));
		update_user_meta($user_id,'businesslocationcity',esc_attr($_POST['businesslocationcity']));
		update_user_meta($user_id,'businesslocationstate',$_POST['businesslocationstate']);
		update_user_meta($user_id,'advertised',$_POST['advertised']);
		update_user_meta($user_id,'businessdescription',esc_attr($_POST['businessdescription']));
		update_user_meta($user_id,'businesskey',esc_attr($_POST['businesskey']));
		//about competitors
		update_user_meta($user_id,'aboutcompetitors',esc_attr($_POST['aboutcompetitors']));
		//orangegoal newsletter
		update_user_meta($user_id,'orangenews',$_POST['orangenews']);
	}
?>