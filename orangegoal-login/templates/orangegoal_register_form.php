<!-- register form -->
<?php if($attributes['show_title']) : ?>
	<h2><?php _e('Register to orangegoal','login-orangegoal') ?></h2>
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
			printf(__('You have successfully registered to <strong>%s</strong>. We have emailed your password to the email address you entered.','login-orangegoal'),get_bloginfo('name'));
		?>
	</p>
<?php endif; ?>
<!-- /success -->
<form id="signupform" action="<?php echo wp_registration_url(); ?>" method="post">
	<p>
		<label for="email"><?php _e('Email','login-orangegoal'); ?>	<strong>*</strong></label>
		<input type="text" name="email" id="email" class="input">
	</p>
	<p>
		<label for="first_name"><?php _e('First name','login-orangegoal'); ?> <strong>*</strong></label>
		<input type="text" name="first_name" id="first-name" class="input">
	</p>
	<p>
		<label for="last_name"><?php _e('Last name','login-orangegoal'); ?> <strong>*</strong></label>
		<input type="text" name="last_name" id="last-name" class="input">
		<input type="hidden" name="choose_url" value="<?php echo 'http://',$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];?>"  readonly/>
	</p>	
	<p>
		<?php _e('Your password will be generated automatically and sent to your email address.','login-orangegoal'); ?>
	</p>
	<p>
		<input type="submit" name="submit" class="register-button" value="<?php _e('Register','login-orangegoal'); ?>">
	</p>
</form>
<?php the_widget('Facebook_Login_Widget'); ?>
<!-- register form -->