<!-- wp form -->
<?php if($attributes['show_title']) : ?>
	<h2><?php _e('Sign in to Orangegoal Digital Marketing','login-orangegoal') ?></h2>
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
<!-- success -->
<?php if ($attributes['registered']) : ?>
	<p>
		<?php
			printf(__('You have successfully registered to <strong>Orangegoal Digital Marketing</strong>. <a href="%s">Log in with your email and password</a>.','login-orangegoal'),home_url('member-login'));
		?>
	</p>
<?php endif; ?>
<!-- /success -->
<!-- orangegoal custom login -->
<?php
	wp_login_form(
		array(
			'label_username' => __('Email','login-orangegoal'),
			'label_log_in' => __('Sign in','login-orangegoal'),
			'remember' => true,
			'redirect' => $attributes['redirect'],
		)
	);	
?>
<a href="<?php echo wp_lostpassword_url(); ?>" class="forgot-pass"><?php _e('Forgot your password?','login-orangegoal'); ?></a>
<!-- orangegoal custom login -->