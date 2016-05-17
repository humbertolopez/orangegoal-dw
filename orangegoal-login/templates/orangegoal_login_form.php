<!-- wp form -->
<?php if($attributes['show_title']) : ?>
	<h2><?php _e('Sign in to orangegoal','login-orangegoal') ?></h2>
<?php endif; ?>
<!-- show errors -->
<?php if(count($attributes['errors']) > 0): ?>
	<?php foreach ($attributes['errors'] as $error) : ?>
		<?php echo $error; ?>
	<?php endforeach ?>
<?php endif; ?>
<!-- /show errors -->
<!-- logged out message -->
<?php if($attributes['logged_out']) : ?>
	<?php _e('You have signed out. Come back again soon!','login-orangegoal'); ?>
<?php endif; ?>
<!-- logged out message -->
<!-- orangegoal custom login -->
<?php
	wp_login_form(
		array(
			'label_username' => __('Email','login-orangegoal'),
			'label_log_in' => __('Sign in','login-orangegoal'),
			'redirect' => $attributes['redirect'],
		)
	);	
?>
<?php the_widget('Facebook_Login_Widget'); ?>
<a href="<?php echo wp_lostpassword_url(); ?>" class="forgot-pass"><?php _e('Forgot your password?','login-orangegoal'); ?></a>
<!-- orangegoal custom login -->