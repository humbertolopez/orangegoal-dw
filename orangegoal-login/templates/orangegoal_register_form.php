<!-- register form -->
<?php if($attributes['show_title']) : ?>
	<h2><?php _e('Register to Orangegoal Digital Marketing','login-orangegoal') ?></h2>
<?php endif; ?>
<!-- show errors -->
<?php if(count($attributes['errors']) > 0): ?>
	<?php foreach ($attributes['errors'] as $error) : ?>
		<?php echo $error; ?>
	<?php endforeach ?>
<?php endif; ?>
<!-- /show errors -->
<!-- success -->
<?php if ($attributes['registered']) : ?>
	<p>
		<?php
			printf(__('You have successfully registered to <strong>Orangegoal Digital Marketing</strong>. <a href="%s">Log in with your email and password</a>.','login-orangegoal'),home_url('member-login'));
		?>
	</p>
<?php endif; ?>
<!-- /success -->
<!-- logged out message -->
<?php if($attributes['logged_out']) : ?>
	<?php _e('You have signed out. Come back again soon!','login-orangegoal'); ?>
<?php endif; ?>
<!-- logged out message -->
<form id="signupform" action="<?php echo wp_registration_url(); ?>" method="post">
	<p>
		<!--<label for="email"><?php _e('Email','login-orangegoal'); ?>	<strong>*</strong></label> -->
		<input type="text" name="email" id="email" class="input" placeholder="<?php _e('Email','login-orangegoal'); ?>">
	</p>
	<p>
		<!-- <label for="first_name"><?php _e('First name','login-orangegoal'); ?> <strong>*</strong></label> -->
		<input type="text" name="first_name" id="first-name" class="input" placeholder="<?php _e('First name','login-orangegoal'); ?>">
	</p>
	<!-- <p>
		<label for="last_name"><?php _e('Last name','login-orangegoal'); ?> <strong>*</strong></label>
		<input type="text" name="last_name" id="last-name" class="input" placeholder="<?php _e('Last name','login-orangegoal'); ?>">
	</p>  -->
	<p>
		<!-- <label for="password"><?php _e('Your password','login-orangegoal'); ?> <strong>*</strong></label> -->
		<input type="password" name="password" id="password" class="input" placeholder="<?php _e('Your password','login-orangegoal'); ?>">
	</p>
	<p>
		<!-- <label for="repeat_password"><?php _e('Repeat your password','login-orangegoal'); ?> <strong>*</strong></label> -->
		<input type="password" name="repeat_password" id="repeat_password" class="input" placeholder="<?php _e('Repeat your password','login-orangegoal'); ?>">
	</p>
	<!-- hidden -->
		<input type="text" name="choose_diagnostic" id="choose_diagnostic">
	<!-- / hidden -->
	<p>
		<input type="submit" name="submit" class="register-button" value="<?php _e('Register!','login-orangegoal'); ?>">
	</p>
</form>
<!-- register form -->